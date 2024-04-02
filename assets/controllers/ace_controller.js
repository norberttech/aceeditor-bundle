import {Controller} from '@hotwired/stimulus';
import Ace from 'ace-builds/src-noconflict/ace.js';
import 'ace-builds/src-noconflict/ext-language_tools.js';

class MyWorker extends Worker {
	constructor(moduleScriptUrl) {
		const importMapScript = document.querySelector('script[type="importmap"]');
		const importMap = JSON.parse(importMapScript.textContent);
		let type = 'script';
		for (const [key, url] of Object.entries(importMap.imports)) {
			let parts = key.split('/');
			if (parts.length > 1) {
				let key = parts[parts.length - 1];
				if (key === moduleScriptUrl) {
					moduleScriptUrl = url;
					type = 'module';
					break;
				}
			}
		}
		super(moduleScriptUrl, {
			type: type,
		});
	}
}

Worker = MyWorker;

export default class extends Controller {
	static targets = ['editor', 'textarea'];
	static values = {
		options: Object
	};

	connect() {
		const importMapScript = document.querySelector('script[type="importmap"]');
		const importMap = JSON.parse(importMapScript.textContent);
		for (const [key, url] of Object.entries(importMap.imports)) {
			let parts = key.split('/');
			if (parts.length > 1) {
				let key = parts[parts.length - 1];
				['worker'].forEach((type) => {
					if (key.substring(0, type.length + 1) === type + '-' && key.substring(key.length - 3) === '.js') {
						let module = "ace/mode/" + key.substring(type.length + 1, key.length - 3) + "_worker";
						Ace.config.setModuleLoader(module, () => import(url));
					}
				});
				['mode', 'theme'].forEach((type) => {
					if (key.substring(0, type.length + 1) === type + '-' && key.substring(key.length - 3) === '.js') {
						let module = "ace/" + type + "/" + key.substring(type.length + 1, key.length - 3);
						Ace.config.setModuleLoader(module, () => import(url));
					}
				});
			}
		}

		Ace.config.set("loadWorkerFromBlob", false);
		this.editor = Ace.edit(this.editorTarget);

		this.textareaTarget.style.visibility = 'hidden';
		this.textareaTarget.style.width = this.optionsValue.width + this.optionsValue.widthUnit;
		this.textareaTarget.style.height = this.optionsValue.height + this.optionsValue.heightUnit;

		this.editorTarget.style.fontSize = this.optionsValue.fontSize + 'px';
		this.editorTarget.style.width = this.optionsValue.width + this.optionsValue.widthUnit;
		this.editorTarget.style.height = this.optionsValue.height + this.optionsValue.heightUnit;
		this.editorTarget.style.marginTop = -(this.optionsValue.height) + this.optionsValue.heightUnit;

		this.editor.setTheme(this.optionsValue.theme);
		this.editor.setKeyboardHandler(this.optionsValue.keyboardHandler);
		this.editor.getSession().setMode(this.optionsValue.mode);
		this.editor.getSession().setValue(this.textareaTarget.value);

		if (this.optionsValue.readOnly !== null) {
			this.editor.setReadOnly(this.optionsValue.readOnly ? 'true' : 'false');
		}
		if (this.optionsValue.showPrintMargin !== null) {
			this.editor.setShowPrintMargin(this.optionsValue.optionsshowPrintMargin ? 'true' : 'false');
		}
		if (this.optionsValue.showInvisibles !== null) {
			this.editor.setShowInvisibles(this.optionsValue.showInvisibles ? 'true' : 'false');
		}
		if (this.optionsValue.highlightActiveLine !== null) {
			this.editor.setHighlightActiveLine(this.optionsValue.highlightActiveLine ? 'true' : 'false');
		}
		if (this.optionsValue.tabSize !== null) {
			this.editor.getSession().setTabSize(this.optionsValue.tabSize);
		}
		if (this.optionsValue.useSoftTabs) {
			this.editor.getSession().setUseSoftTabs(this.optionsValue.useSoftTabs ? 'true' : 'false');
		}
		if (this.optionsValue.useWrapMode !== null) {
			this.editor.getSession().setUseWrapMode(this.optionsValue.useWrapMode ? 'true' : 'false');
		}
		let options = {};
		if (this.optionsValue.optionsEnableBasicAutocompletion !== null) {
			options.enableBasicAutocompletion = this.optionsValue.optionsEnableBasicAutocompletion;
		}
		if (this.optionsValue.optionsEnableLiveAutocompletion !== null) {
			options.enableLiveAutocompletion = this.optionsValue.optionsEnableLiveAutocompletion;
		}
		if (this.optionsValue.optionsEnableSnippets !== null) {
			options.enableSnippets = this.optionsValue.optionsEnableSnippets;
		}
		this.editor.setOptions(options);

		let wordList = this.optionsValue.autocompleteWorlds;
		let staticWordCompleter = {
			getCompletions: function (editor, session, pos, prefix, callback) {
				callback(null, wordList.map(function (word) {
					return {
						caption: word,
						value: word,
						meta: "static"
					};
				}));

			}
		}
		this.editor.completers = [staticWordCompleter];

		this.editor.getSession().on('change', () => {
			this.textareaTarget.value = this.editor.getSession().getValue();
		});
	}
}

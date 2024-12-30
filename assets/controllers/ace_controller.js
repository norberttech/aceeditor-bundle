import {Controller} from '@hotwired/stimulus';
import Ace from 'ace-builds/src-noconflict/ace.js';
import 'ace-builds/src-noconflict/ext-language_tools.js';

/**
 * @see https://developer.mozilla.org/en-US/docs/Web/API/Web_Workers_API/Using_web_workers
 * @see https://symfony.com/doc/current/frontend/asset_mapper.html#how-does-the-importmap-work
 * Worker is standard JS build in feature for running jobs on background that use ace editor for loading workers.
 * We need override this class to support script from importmap generated from symfony/asset-mapper.
 * So when worker is created with script url, we need to check if this script is in importmap and replace it with correct url.
 * We now that file is in importmap because aceEditor load only filename and in immportmap we have full path to file.
 */
if (typeof Worker !== 'undefined'){
	class AceWorker extends Worker {
		constructor(moduleScriptUrl, options) {
			if (!options) {
				options = {};
			}
			const importMapScript = document.querySelector('script[type="importmap"]');
			const importMap = JSON.parse(importMapScript.textContent);
			for (const [key, url] of Object.entries(importMap.imports)) {
				let parts = key.split('/');
				if (parts.length > 1) {
					let scriptName = parts[parts.length - 1];
					if (scriptName === moduleScriptUrl) {
						moduleScriptUrl = url;
						options.type = 'module';
						break;
					}
				}
			}
			super(moduleScriptUrl, options);
		}
	}

	Worker = AceWorker;
}
export default class extends Controller {
	static targets = ['editor', 'textarea'];
	static values = {
		options: Object
	};

	connect() {
		/**
		 * @see https://symfony.com/doc/current/frontend/asset_mapper.html#how-does-the-importmap-work
		 * We need to load ace editor modules from importmap generated from symfony/asset-mapper.
		 * So we need call Ace.config.setModuleLoader("ace/mode/javascript", () => import("<real path for javascript module file>")
		 * We now that file is for aceEditor because it ends with "mode-<mode>.js" or "theme-<theme>.js" name.
		 */
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
		// We need to set this to false because we want to load worker by AceWorker not from blob.
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

		// Enable autocompletion worlds sent from symfony AceEditorType
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
			this.textareaTarget.dispatchEvent(new Event('change', { bubbles: true }));
		});
	}
}

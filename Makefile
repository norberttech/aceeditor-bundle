export DOCKER_BUILDKIT=1

DOCKER_BUILD_ARGS ?=

ifneq ($(PHP_VERSION),)
DOCKER_BUILD_ARGS += --build-arg PHP_VERSION=$(PHP_VERSION)
endif

DOCKER_RUN_IID_FILE = .docker_shell-$(PHP_VERSION).iid

.PHONY: shell
shell:
	@docker build $(DOCKER_BUILD_ARGS) --iidfile $(DOCKER_RUN_IID_FILE) .
	@docker run \
		--init -it --rm \
		--user $$(id -u):$$(id -g) \
		-v $(PWD):/src \
		$$(cat $(DOCKER_RUN_IID_FILE))

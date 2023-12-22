export DOCKER_BUILDKIT=1

DOCKER_BUILD_ARGS ?=

ifneq ($(PHP_VERSION),)
DOCKER_BUILD_ARGS += --build-arg PHP_VERSION=$(PHP_VERSION)
endif

.PHONY: shell
shell:
	@docker build $(DOCKER_BUILD_ARGS) --iidfile .docker_shell.iid .
	@docker run \
		--init -it --rm \
		--user $$(id -u):$$(id -g) \
		-v $(PWD):/src \
		$$(cat .docker_build.iid)

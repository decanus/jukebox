SHELL := /bin/bash
PATH  := ./node_modules/.bin:$(PATH)

BUNDLE := build/js/mirror.js
JS_SOURCES := $(shell find ./js -name "*.js")
JS_BUILDS := $(subst ./js/,./.js-build/,$(JS_SOURCES))

.PHONY: all clean lint deps

all: $(BUNDLE)

deps:
	npm prune
	npm install

clean:
	rm -rf build/ .js-build/ $(BUNDLE)

build/js/mirror.js: $(JS_BUILDS)
	@mkdir -p $(dir $@)
ifeq ($(JUKEBOX_ENV),production)
	browserify --dg=false --no-bundle-external -g [ uglifyify --no-sourcemap ] -p bundle-collapser/plugin .js-build/mirror.js | uglifyjs --screw-ie8 --mangle -o $@
else
	browserify --dg=false --no-bundle-external .js-build/mirror.js > $@
endif

.js-build/%: js/%
	@mkdir -p $(dir $@)
	babel $< > $@

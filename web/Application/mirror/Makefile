SHELL := /bin/bash
PATH  := ./node_modules/.bin:$(PATH)

BUNDLE := build/js/mirror.js build/js/vendor.js
JS_SOURCES := $(shell find ./js -name "*.js")
JS_BUILDS := $(subst ./js/,./.js-build/,$(JS_SOURCES))

# we manually list the polyfills because they need to be in a certain order
POLYFILLS := vendor/polyfills/MutationObserver.js \
			 vendor/polyfills/CustomElementsV1.js \
			 vendor/polyfills/harmony-collections.js

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
	browserify --debug --dg=false --no-bundle-external .js-build/mirror.js > $@
endif

build/js/vendor.js: $(POLYFILLS)
	uglifyjs --screw-ie8 $+ > $@

.js-build/%: js/%
	@mkdir -p $(dir $@)
	babel $< > $@

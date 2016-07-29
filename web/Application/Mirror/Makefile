SHELL := /bin/bash
PATH  := ./node_modules/.bin:$(PATH)

BUNDLE := build/js/mirror.js build/js/vendor.js
JS_SOURCES := $(shell find ./js -name "*.js")
JS_LIBRARY := $(shell find ../Library/lib -name "*.js")
ROLLUP_CONFIG := .rollup.config.js

# we manually list the polyfills because they need to be in a certain order
POLYFILLS := vendor/polyfills/MutationObserver.js \
			 vendor/polyfills/CustomElementsV1.js \
			 vendor/polyfills/harmony-collections.js

.PHONY: all clean deps

all: $(BUNDLE)

deps:
	npm prune
	npm install

clean:
	rm -rf build/

build/js/mirror.js: $(JS_SOURCES) $(JS_LIBRARY)
	@mkdir -p $(@D)
	@rm -f $@.map
	rollup -c $(ROLLUP_CONFIG) -o $@ js/mirror.js

build/js/vendor.js: $(POLYFILLS)
	mkdir -p $(@D)
	uglifyjs --screw-ie8 $+ > $@

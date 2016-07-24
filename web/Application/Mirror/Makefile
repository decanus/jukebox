SHELL := /bin/bash
PATH  := ./node_modules/.bin:$(PATH)

BUNDLE := build/js/mirror.js build/js/vendor.js
JS_SOURCES := $(shell find ./js -name "*.js")
JS_LIBRARY := $(shell find ../Library/lib -name "*.js")

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
	rm -rf build/ .cache/

build/js/mirror.js: $(JS_SOURCES) $(JS_LIBRARY)
	@mkdir -p $(@D)
ifeq ($(JUKEBOX_ENV),production)
	browserify js/jukebox.js -t [ babelify --babelrc=false --extends $(abspath .babelrc) ] --no-builtins --no-bf --igv= --no-bundle-external --dg=false -g [ uglifyify --no-sourcemap ] -p bundle-collapser/plugin js/mirror.js | uglifyjs --screw-ie8 --mangle -o $@
else
	@mkdir -p .cache
	browserifyinc --cachefile .cache/browserify-cache.json js/mirror.js -t [ babelify --babelrc=false --extends $(abspath .babelrc) ] --no-builtins --no-bf --igv= --no-bundle-external --dg=false -o $@
endif

build/js/vendor.js: $(POLYFILLS)
	mkdir -p $(@D)
	uglifyjs --screw-ie8 $+ > $@

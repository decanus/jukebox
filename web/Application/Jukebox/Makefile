#
# (c) 2016 Jukebox <www.jukebox.ninja>
#

SHELL := /bin/bash
PATH  := ./node_modules/.bin:$(PATH)

BUNDLE := data/config.json build/js/jukebox.js build/js/polyfills.js build/js/views.js
POLYFILLS := $(wildcard polyfills/*.js)
VIEWS := $(shell find views -name "*.handlebars")

JSON_FILES := $(shell find data -name "*.json")

JS_SOURCES := $(shell find ./js -name "*.js")
JS_BUILDS := $(subst ./js/,./js-build/,$(JS_SOURCES))

.PHONY: all clean install-deps

all: $(BUNDLE)

clean:
	rm -rf build/ .cache/ $(BUNDLE)

deps:
	npm prune
	npm install

build/js/jukebox.js: $(JSON_FILES) $(JS_SOURCES)
	@mkdir -p $(dir $@)
ifeq ($(JUKEBOX_ENV),production)
	browserify js/jukebox.js -t [ babelify --babelrc=false --extends $(abspath .babelrc) ] --no-builtins --no-bf --igv= --no-bundle-external --dg=false -g [ uglifyify --no-sourcemap ] -p bundle-collapser/plugin js/jukebox.js | uglifyjs --screw-ie8 --mangle -o $@
else
	@mkdir -p .cache
	browserifyinc --cachefile .cache/browserify-cache.json js/jukebox.js -t [ babelify --babelrc=false --extends $(abspath .babelrc) ] --no-builtins --no-bf --igv= --no-bundle-external --dg=false > $@
endif

build/js/views.js: $(VIEWS)
ifeq ($(JUKEBOX_ENV),production)
	handlebars views/ | uglifyjs --screw-ie8 --mangle -o $@
else
	handlebars views/ -f $@ -m
endif

build/js/polyfills.js: $(POLYFILLS)
	@mkdir -p $(dir $@)
	uglifyjs $^ -o $@

data/config.json:
ifeq ($(JUKEBOX_ENV),production)
	cd $(abspath data) && ln -sf config.live.json config.json
else
	cd $(abspath data) && ln -sf config.dev.json config.json
endif

#
# (c) 2016 Jukebox <www.jukebox.ninja>
#

SHELL := /bin/bash
PATH  := ./node_modules/.bin:$(PATH)

BUNDLE := build/js/jukebox.js build/js/polyfills.js build/js/views.js
POLYFILLS := $(wildcard polyfills/*.js)
VIEWS := $(shell find views -name "*.handlebars")

JS_SOURCES := $(shell find ./js -name "*.js")
JS_BUILDS := $(subst ./js/,./js-build/,$(JS_SOURCES))

.PHONY: all clean lint install-deps

all: $(BUNDLE)

clean:
	rm -rf build/ js-build/ $(BUNDLE)

lint:
	standard "js/**/*.js"

deps:
	npm prune
	npm install

build/js/jukebox.js: data/config.json $(JS_BUILDS)
	@mkdir -p $(dir $@)
ifeq ($(JUKEBOX_ENV),production)
	browserify --dg=false --no-bundle-external -g [ uglifyify --no-sourcemap ] -p bundle-collapser/plugin js-build/jukebox.js | uglifyjs --screw-ie8 --mangle -o $@
else
	browserify --dg=false --no-bundle-external js-build/jukebox.js > $@
endif

js-build/%: js/%
	@mkdir -p $(dir $@)
	babel $< > $@

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
	cd data && ln -sf prod.json config.json
else
	cd data && ln -sf dev.json config.json
endif

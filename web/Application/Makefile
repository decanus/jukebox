#
# (c) 2016 Jukebox <www.jukebox.ninja>
#

SHELL := /bin/bash
PATH  := ./node_modules/.bin:$(PATH)

BUNDLE := build/js/jukebox.js build/js/polyfills.js build/js/views.js
JS_FILES := $(shell find js -name "*.js")
POLYFILLS := $(wildcard polyfills/*.js)
VIEWS := $(shell find views -name "*.handlebars")

.PHONY: all clean lint install-deps

all: $(BUNDLE)

clean:
	rm -rf build/ $(BUNDLE)

lint:
	lessc --lint styles/jukebox.less
	standard "js/**/*.js"

install-deps:
	npm install

build/js/jukebox.js: data/tokens.json $(JS_FILES)
	@mkdir -p $(dir $@)
ifeq ($(JUKEBOX_ENV),production)
	browserify -t [ babelify ] -t envify -g [ uglifyify --no-sourcemap ] -p bundle-collapser/plugin js/jukebox.js | uglifyjs --screw-ie8 --mangle -o $@
else
	browserify -t [ babelify ] -t envify js/jukebox.js > $@
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

data/tokens.json:
ifeq ($(JUKEBOX_ENV),production)
	cd data && ln -sf prod.json tokens.json
else
	cd data && ln -sf dev.json tokens.json
endif

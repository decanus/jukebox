SHELL := /bin/bash
PATH  := $(PATH):node_modules/.bin

COMMON_LESS_FILES = $(shell find less/common -name "*.less")

.PHONY: all deps clean
.SECONDEXPANSION:

all: build/css/jukebox.css build/css/mirror.css build/svg/icons.svg

clean:
	rm -rf build

deps:
	npm prune
	npm install

build/css/%.css: less/%.less $$(shell find less/$$* -name "*.less") $(COMMON_LESS_FILES)
	@mkdir -p $(@D)
	lessc -clean-css $< | postcss -u autoprefixer -u postcss-selector-matches -o $@

build/svg/icons.svg: svg/icons.svg
	@mkdir -p $(@D)
	pretty -m $< > $@

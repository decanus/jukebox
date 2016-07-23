SHELL := /bin/bash
PATH  := $(PATH):node_modules/.bin

LESS_FILES = $(shell find less -name "*.less")

.PHONY: all deps

all: build/css/jukebox.css build/svg/icons.svg

deps:
	npm prune
	npm install

build/css/jukebox.css: $(LESS_FILES)
	@mkdir -p $(@D)
	lessc -clean-css less/jukebox.less | postcss -u autoprefixer -u postcss-selector-matches -o $@

build/svg/icons.svg: svg/icons.svg
	@mkdir -p $(@D)
	pretty -m $< > $@

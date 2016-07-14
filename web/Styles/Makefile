SHELL := /bin/bash
PATH  := $(PATH):node_modules/.bin

LESS_FILES = $(shell find less -name "*.less")

.PHONY: all deps

all: css/jukebox.css

deps:
	npm install

css/jukebox.css: $(LESS_FILES)
	@mkdir -p $(@D)
	lessc -clean-css less/jukebox.less | postcss -u autoprefixer -u postcss-selector-matches -o $@

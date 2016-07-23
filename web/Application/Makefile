.PHONY: all jukebox mirror

all: jukebox mirror

jukebox:
	@$(MAKE) -C jukebox

mirror:
	@$(MAKE) -C mirror

deps:
	@$(MAKE) deps -C jukebox
	@$(MAKE) deps -C mirror

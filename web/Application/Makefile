.PHONY: all deps clean

all:
	@$(MAKE) -C Jukebox
	@$(MAKE) -C Mirror

clean:
	@$(MAKE) clean -C Jukebox
	@$(MAKE) clean -C Mirror

deps:
	@$(MAKE) deps -C Jukebox
	@$(MAKE) deps -C Mirror

.PHONY: all deps clean

all:
	@$(MAKE) -C Jukebox
	@$(MAKE) -C mirror

clean:
	@$(MAKE) clean -C Jukebox
	@$(MAKE) clean -C mirror

deps:
	@$(MAKE) deps -C Jukebox
	@$(MAKE) deps -C mirror

.PHONY: all styles application

all: application styles

styles:
	@$(MAKE) -C web/Styles

application:
	@$(MAKE) -C web/Application

deps:
	@$(MAKE) deps -C web/Application
	@$(MAKE) deps -C web/Styles

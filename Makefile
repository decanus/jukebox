.PHONY: all styles application

all: application styles sockets

styles:
	@$(MAKE) -C web/Styles

application:
	@$(MAKE) -C web/Application

sockets:
	@$(MAKE) -C web/Sockets

deps:
	@$(MAKE) deps -C web/Application
	@$(MAKE) deps -C web/Styles
	@$(MAKE) deps -C web/Sockets

.PHONY: test

coverage:
	./vendor/bin/phpunit --coverage-html coverage-report-html

lint:
	./vendor/bin/phpcs --standard=phpcs-ruleset.xml src test

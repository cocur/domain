test: lint test-unit

test-unit:
	./vendor/bin/phpunit -c .

lint:
	./vendor/bin/jsonlint ./data/tld.json

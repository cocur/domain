test:
	./vendor/bin/jsonlint ./data/tld.json
	./vendor/bin/phpunit -c .

kphp := docker run -ti -v `pwd`/:/tmp/dev:rw -p 8080:8080 vkcom/kphp

.PHONY: all gen build pkhp

all: gen
	$(MAKE) build

build:
	kphp -M cli testCanParseJson.php && kphp_out/cli --Xkphp-options --disable-sql
	kphp -M cli testHandlers.php && ./kphp_out/cli  --Xkphp-options --disable-sql

gen:
	php genreflection.php A > A_reflection.php.tmp
	mv -f A_reflection.php.tmp A_reflection.php
	php genreflection.php B > B_reflection.php.tmp
	mv -f B_reflection.php.tmp B_reflection.php

kphp:
	$(kphp) 
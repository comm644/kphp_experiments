all: gen
	$(MAKE) build

build:
	kphp -M cli testGetObjectVars.php
	kphp_out/cli

gen:
	php mksetter.php A > A_reflection.php.tmp
	mv -f A_reflection.php.tmp A_reflection.php

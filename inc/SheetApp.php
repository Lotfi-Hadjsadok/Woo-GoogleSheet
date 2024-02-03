<?php

namespace Inc;

class SheetApp {
	const Classes = array(
		SheetAdmin::class,
	);
	public function start() {
        add_action( 'after_setup_theme', array(\Carbon_Fields\Carbon_Fields::class,'boot' ));
		foreach ( self::Classes as $class ) {
				(new $class)->init();
		}
	}
}

<?php
class R4c8e68c46fb4472f8fd638ba6318cd70 extends CakeRelease {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = 'Migration for MeioUpload version 0.8';

/**
 * Plugin name
 *
 * @var string
 * @access public
 */
	public $plugin = 'MeioUpload';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
		),
		'down' => array(
		),
	);

	
/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}
}
?>
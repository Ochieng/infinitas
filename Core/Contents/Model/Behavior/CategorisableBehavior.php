<?php
	/**
	 * CategorisableBehavior Allows any model to have categories.
	 *
	 * Add the field category_id to your model to have it all auto bind the
	 * behaviors and relate the models
	 *
	 * @copyright Copyright (c) 2009 Carl Sutton ( dogmatic69 )
	 * @link http://infinitas-cms.org
	 * @package Infinitas.Categories.models.behaviors
	 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
	 * @since 0.7a
	 *
	 *
	 *
	 */
	App::uses('ModelBehavior', 'Model');
	class CategorisableBehavior extends ModelBehavior {
		/**
		 * Contain settings indexed by model name.
		 *
		 * @var array
		 */
		public $settings = array();

		/**
		 * some default options of the behavior, you can pass this in the setup
		 * to change the way it works.
		 *
		 * @var array
		 */
		protected $_defaults = array(
			'categoryAlias' => 'GlobalCategory',
			'categoryClass' => 'Contents.GlobalCategory',
			'foreignKey' => 'category_id',
			'counterCache' => 'item_count',
			'unsetInAfterFind' => false,
			'resetBinding' => false
		);

		/**
		 * Initiate behaviour for the model using settings.
		 *
		 * @param object $Model Model using the behaviour
		 * @param array $settings Settings to override for model.
		 *
		 * @return void
		 */
		public function setup($Model, $settings = array()) {
			$this->settings[$Model->alias] = array_merge($this->_defaults, $settings);

			$Model->bindModel(
				array(
					'belongsTo' => array(
						$this->settings[$Model->alias]['categoryAlias'] => array(
							'className' => $this->settings[$Model->alias]['categoryClass'],
							'foreignKey' => $this->settings[$Model->alias]['foreignKey'],
							//'counterCache' => $this->settings[$Model->alias]['counterCache'],
							'fields' => array(
								$this->settings[$Model->alias]['categoryAlias'] . '.id',
								$this->settings[$Model->alias]['categoryAlias'] . '.title',
								$this->settings[$Model->alias]['categoryAlias'] . '.slug',
								$this->settings[$Model->alias]['categoryAlias'] . '.active',
								$this->settings[$Model->alias]['categoryAlias'] . '.group_id',
								$this->settings[$Model->alias]['categoryAlias'] . '.parent_id'
							)
						)
					),
				),
				$this->settings[$Model->alias]['resetBinding']
			);
		}

		/**
		 * get a list of categories.
		 *
		 * @param object $Model the model that the behavior is affecting
		 *
		 * @return array
		 */
		public function generateCategoryList($Model) {
			return $Model->GlobalCategory->generateTreeList();
		}

		/**
		 * find all models that are using the category plugin, count the rows in
		 * each and then save that as the count.
		 *
		 * @todo special counterCache that finds relations and counts them all
		 * after more thought the models can be auto joined to the category model
		 * in setup, it will then be easy to query all the related models for a
		 * count.
		 *
		 * @param object $Model the model being worked with
		 * @param bool $created if the row is new or updated
		 *
		 * @return boolean
		 */
		public function afterSave($Model, $created) {
			return parent::afterSave($Model, $created);
		}
	}
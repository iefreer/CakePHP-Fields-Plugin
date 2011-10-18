<?php
/**
 * Fields component
 * @version 0.1
 * @author ryan <ryan.chen@jigocity.com>
 * @license	http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class FieldsComponent extends Object {
	var $actions;
/**
 * Initializes FieldsComponent for use in the controller
 *
 * @param object $controller A reference to the instantiating controller object
 * @param array $settings Array of settings for the Component
 * @return void
 * @access public
 */
	function initialize(&$controller, $settings = array()) {
		Configure::load('fields.fields');
	}

	//called after Controller::beforeFilter()
	function startup(&$controller) {		
		$actions = Configure::read(strtolower($controller->name).'.actions');
		if (in_array($controller->action, $actions)) {
			$this->processActions($controller);
		}		
	}

	//called after Controller::render()
	function shutdown(&$controller) {
	}
		
	function processActions(&$controller) {
		$this->processFields($controller);
	}
	
	function isAssociated(&$controller, &$model) {
		$associates = $controller->{$controller->modelClass}->getAssociated();
		foreach($associates as $model_name=>$relation) {
			if($model_name == $model) return true;
		}
		return false;
	}
/**
 * Function which will change returned fields for query
 * 
 * @param object $controller the class of the controller which call this component
 * @access public
 */
	function processFields(&$controller) {
		//read field list from configuration, in format of model_name.field_name
		$fields = Configure::read(strtolower($controller->name).'.fields');
		if(!empty($fields)) {
			foreach($fields as $model=>$flds) {
				$Model = ClassRegistry::init($model);
				$valid_flds = array();
				foreach($flds as $fld) {
					if($Model->hasField($fld)) {
						$valid_flds[] = $fld;
					}
				}
				if($this->isAssociated($controller, $model)) {
					$controller->paginate[$controller->modelClass]['contain'][$model]['fields'] = $valid_flds;
				} else {
					$controller->paginate[$controller->modelClass]['fields'] = $valid_flds;
				}
			}
		}
	}

/**
 * Checks if all keys are held within an array
 *
 * @param array $array
 * @param array $keys
 * @param boolean $size
 * @return boolean array has keys, optional check on size of array
 * @author savant
 **/
	function _arrayHasKeys($array, $keys, $size = null) {
		if (count($array) != count($keys)) return false;

		$array = array_keys($array);
		foreach ($keys as &$key) {
			if (!in_array($key, $array)) {
				return false;
			}
		}
		return true;
	}
}
?>

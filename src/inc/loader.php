<?php
/**
 * Register all actions for the plugin
 * @since      1.0.0
 * @author     Ruslan Ismailov
 */
declare( strict_types = 1 );
 
namespace RemoteDataGetter\Inc; 

class Loader 
{
    /**
	 * The array of actions registered with WordPress.
	 */
	protected $actions;
    
	public function __construct() 
	{
		$this->actions = array();
    }
    
    /**
	* Add a new action to the collection.
	*/
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) 
	{
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}
    
    /**
	 * A utility function that is used to register the actions to  single collection.
	 */
	private function add( $hooks, $hook, $component, $callback, $priority, $accepted_args ): array 
	{
		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;
    }
    
   	/**
	 * Register the actions with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }
	} 
}
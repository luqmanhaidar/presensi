<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Theme_Base extends Theme {

    public $name			= 'Base';
    public $author			= 'Scott Parry';
    public $author_website	= 'http://ikreativ.com/';
    public $website			= 'http://ikreativ.com/';
    public $description		= 'An HTML5 base template filled with goodies to get you up and running quickly.';
    public $version			= '1.0';
	public $options 		= array(
									'background' => array(
														'title'         => 'Background',
														'description'   => 'Choose the default background for the theme.',
														'default'       => 'fabric',
														'type'          => 'select',
														'options'       => 'black=Black | fabric=Fabric | graph=Graph | leather=Leather | noise=Noise | texture=Texture',
														'is_required'   => TRUE),
																
									'slider' => array(
														'title'         => 'Slider',
														'description'   => 'Would you like to display the slider on the homepage?',
														'default'       => 'yes',
														'type'          => 'radio',
														'options'       => 'yes=Yes | no=No',
														'is_required'   => TRUE),
									'color' => array(
														'title'         => 'Default Theme Color',
														'description'   => 'This changes things like background color, link colors etc…',
														'default'       => 'pink',
														'type'          => 'select',
														'options'       => 'red=Red | orange=Orange | yellow=Yellow | green=Green | blue=Blue | pink=Pink',
														'is_required'   => TRUE),
							);
}

/* End of file theme.php */

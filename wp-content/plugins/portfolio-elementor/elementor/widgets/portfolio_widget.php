<?php
namespace Powerfolio\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 *
 * @since 1.0.0
 */
class ELPT_Portfolio_Widget extends Widget_Base {

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'elpug';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Elementor Portfolio (Powerfolio)', 'powerfolio' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-justified';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'elpug-elements' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'elpug' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$pro_version = true; //pe_fs()->can_use_premium_code__premium_only();

		//=========== Main Settings	==============	
		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'General Settings', 'powerfolio' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'postsperpage',
			[
			   'label'   => __( 'Number of projects to show', 'powerfolio' ),
			   'type'    => Controls_Manager::NUMBER,
			   'default' => 12,
			   'min'     => 1,
			   'max'     => 90,
			   'step'    => 1,
			]
		  );
  
		  //PRO Version Snippet
		  if ( pe_fs()->can_use_premium_code__premium_only() ) {
			  $args = array(
				  'public'   => true,
			  );
			  $the_post_types = get_post_types($args);
			  $this->add_control(
				  'post_type',
				  [
					  'label' => __( 'Post Type to display', 'powerfolio' ),
					  'type' => Controls_Manager::SELECT,
					  'default' => 'elemenfolio',
					  'description' => 'Default: elemenfolio',
					  'options' => $the_post_types,
				  ]
			  );
		  }
		  // END - PRO Version Snippet
  
		  $showfilter_description = '';
  
		  if ( pe_fs()->can_use_premium_code__premium_only() ) {
			  $showfilter_description = __('Only works with the "elemenfolio" post type.', 'powerfolio');
		  }
  
		  $this->add_control(
			  'showfilter',
			  [
				  'label' => __( 'Show category filter?', 'powerfolio' ),
				  'description' => $showfilter_description,
				  'type' => Controls_Manager::SELECT,
				  'default' => 'yes',
				  'options' => [
					  'yes' => __( 'Yes', 'powerfolio' ),
					  'no' => __( 'No', 'powerfolio' ),
				  ]
			  ]
		  );
  
		  $this->add_control(
			  'tax_text',
			  [
				  'label' => __( 'All Categories - Button Text', '' ),
				  'type' => \Elementor\Controls_Manager::TEXT,
				  'default' => __( 'All', '' ),
				  'condition'		=> [
					  'showfilter' => 'yes'
				  ],				
			  ]
		  );
  
		  //PRO Version Snippet
		  if ( pe_fs()->can_use_premium_code__premium_only() ) {
			  $this->add_control(
				  'type',
				  [
					  'label' => __( 'Display specific portfolio category', 'powerfolio' ),
					  'description' => 'Only works with the "elemenfolio" post type.',
					  'type' => Controls_Manager::SWITCHER,
					  'default' => '',
					  'label_on' => __( 'On', 'powerfolio' ),
					  'label_off' => __( 'Off', 'powerfolio' ),
					  'return_value' => 'yes',
				  ]
			  );
  
			  $portfolio_taxonomies = get_terms( array('taxonomy' => 'elemenfoliocategory', 'fields' => 'id=>name', 'hide_empty' => false, ) );
			  $this->add_control(
				  'taxonomy',
				  [
					  'label' => __( 'Select wich portfolio category to show', 'powerfolio' ),
					  'description' => 'Only works with the "elemenfolio" post type.',
					  'type' => Controls_Manager::SELECT,
					  'default' => '',
					  'condition'		=> [
						  'type' => 'yes'
					  ],
					  'options' => $portfolio_taxonomies,
				  ]
			  );
		  }
		  // END - PRO Version Snippet		

		  //Upgrade message for free version		
			if ( !pe_fs()->can_use_premium_code__premium_only() ) {

				$this->add_control(
					'Upgrade_note1',
					[
						'label' => '',
						'type' => \Elementor\Controls_Manager::RAW_HTML,
						'raw' => get_upgrade_message(),
						'content_classes' => 'your-class',
					]
				);
			}
		
		
		$this->end_controls_section();

		//=========== END - Main Settings	==============	

		//=========== Grid Settings	==============	
		$this->start_controls_section(
			'section_grid',
			[
				'label' => __( 'Grid Settings', 'powerfolio' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);	

		//Grid Options
		$style_options = array(
			'masonry' => __( 'Masonry', 'powerfolio' ),
			'box' => __( 'Boxes', 'powerfolio' ),	
		);

		if ( pe_fs()->can_use_premium_code__premium_only() ) {
			$description = '';
		} else {
			$description = __('Upgrade your plan to get access to the special grids. Our exclusive feature! <a href="https://checkout.freemius.com/mode/dialog/plugin/7226/plan/12571/">CLICK TO UPGRADE</a>', 'powerfolio');
		}
		//PRO Version Snippet
		if ( pe_fs()->can_use_premium_code__premium_only() ) {
			$style_options = array(
				'masonry' => __( 'Masonry', 'powerfolio' ),
				'box' => __( 'Boxes', 'powerfolio' ),	
				'grid_builder' => __( 'Grid Builder', 'powerfolio' ),	
				'specialgrid1' => __( 'Special Grid 1', 'powerfolio' ),	
				'specialgrid2' => __( 'Special Grid 2', 'powerfolio' ),		
				'specialgrid3' => __( 'Special Grid 3', 'powerfolio' ),	
				'specialgrid4' => __( 'Special Grid 4', 'powerfolio' ),	
				'specialgrid5' => __( 'Justified 1', 'powerfolio' ),
				'specialgrid6' => __( 'Justified 2', 'powerfolio' ),	
			);

			$description = '';
		}
		// END - PRO Version Snippet

		
		//Style
		$this->add_control(
			'style',
			[
				'label' => __( 'Grid Style', 'powerfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'box',
				//'description' => 'PS: The masonry style and special grids may not work on preview due to some limitations (it works as expected on front-end). Please save then refresh the page to see the preview.',
				'description' => $description,
				'options' => $style_options
			]
		);

		//columns
		$this->add_control(
			'columns',
			[
				'label' => __( 'Number of columns', 'powerfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
					  array(
						'name'     => 'style',
						'operator' => '==',
						 'value'   => 'box',
					  ),
					  array(
						'name'     => 'style',
						'operator' => '==',
						'value'    => 'masonry',
					  )
					)
				),
				'options' => [
					'2' => __( 'Two Columns', 'powerfolio' ),
					'3' => __( 'Three Columns', 'powerfolio' ),
					'4' => __( 'Four Columns', 'powerfolio' ),
					'5' => __( 'Five Columns', 'powerfolio' ),
					'6' => __( 'Six Columns', 'powerfolio' ),
				]
			]
		);

		$margin_description = '';

		if ( pe_fs()->can_use_premium_code__premium_only() ) {
			//$margin_description = __('Does not work with special grids.', 'powerfolio');
		}
		$this->add_control(
			'margin',
			[
				'label' => __( 'Use item margin?', 'powerfolio' ),
				'description' => $margin_description,
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'return_value' => 'yes',
				/*'options' => [
					'yes' => __( 'Yes', 'powerfolio' ),
					'no' => __( 'No', 'powerfolio' ),
				],*/
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
					  array(
						'name'     => 'style',
						'operator' => '==',
						 'value'   => 'box',
					  ),
					  array(
						'name'     => 'style',
						'operator' => '==',
						 'value'   => 'masonry',
					  ),
					  array(
						'name'     => 'style',
						'operator' => '==',
						 'value'   => 'grid_builder',
					  )
					)
				),
			]
		);

		//Margin Size
		$this->add_control(
			'margin_size',
			[
				'label' => __( 'Additional Margin (px)', 'powerfolio' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
					  array(
						'name'     => 'margin',
						'operator' => '==',
						 'value'   => 'yes',
					  )					 
					)
				),
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .elpt-portfolio-content.elpt-portfolio-margin .portfolio-item-wrapper' => 'padding-right: calc(5px + {{SIZE}}{{UNIT}}); padding-left: calc(5px + {{SIZE}}{{UNIT}}); padding-bottom: calc((5px + {{SIZE}}{{UNIT}})*2);',					
				],
			]
		);

		
		//================================== GRID BUILDER ========================	
		for ($i = 1; $i <= 20; $i++) {		
			
			//width
			$item = 'item_'.$i;

			$this->add_control(
				$item.'_heading',
				[
					'label' => __( 'Item '.$i.'', 'powerfolio' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
					'conditions' => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'style',
								'operator' => '==',
								'value'   => 'grid_builder',
							),
							array(
								'name'     => 'postsperpage',
								'operator' => '>=',
								 'value'   => $i,
							)
						)
					),
				]
			);

			$this->add_control(
				$item,
				[
					'label' => __( 'Width (%)', 'powerfolio' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ '%' ],
					'default' => [
						'unit' => '%',
						'size' => 25,
					],
					'range' => [
						'%' => [
							'min' => 10,
							'max' => 100,
							'step' => 5,
						]
					],
					'conditions' => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'style',
								'operator' => '==',
								'value'   => 'grid_builder',
							),
							array(
								'name'     => 'postsperpage',
								'operator' => '>=',
								 'value'   => $i,
							)
						)
					),
					'selectors' => [
						'{{WRAPPER}} .elpt-portfolio-content .portfolio-item-wrapper:nth-child('.$i.')' => 'width: {{SIZE}}{{UNIT}} !important;',
					],
				]
			);

			//height
			$itemh = 'item_height_'.$i;
			$this->add_control(
				$itemh,
				[
					'label' => __( 'Height (px)', 'powerfolio' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'px' ],
					'default' => [
						'unit' => 'px',
						'size' => 280,
					],
					'range' => [
						'px' => [
							'min' => 20,
							'max' => 840,
							'step' => 20,
						]
					],
					'conditions' => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'style',
								'operator' => '==',
								'value'   => 'grid_builder',
							),
							array(
								'name'     => 'postsperpage',
								'operator' => '>=',
								 'value'   => $i,
							)
						)
					),
					'selectors' => [
						//'{{WRAPPER}} .elpt-portfolio-content .portfolio-item-wrapper:nth-child('.$i.')' => 'height: {{SIZE}}{{UNIT}} !important;',
						'{{WRAPPER}} .elpt-portfolio-content .portfolio-item-wrapper:nth-child('.$i.') a' => 'height: {{SIZE}}{{UNIT}} !important;',
					],
				]
			);

			/*$this->add_control(
				'hr_'.$i,
				[
					'type' => \Elementor\Controls_Manager::DIVIDER,
					'conditions' => array(
						'relation' => 'and',
						'terms'    => array(
							array(
								'name'     => 'style',
								'operator' => '==',
								'value'   => 'grid_builder',
							),
							array(
								'name'     => 'postsperpage',
								'operator' => '>=',
								 'value'   => $i,
							)
						)
					),
				]
			);*/
		}


		
		//================================== END OF GRID BUILDER==================		
		

		//Box Height
		$this->add_control(
			'box_height',
			[
				'label' => __( 'Box Height (px)', 'powerfolio' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px'],
				'conditions' => array(
					'relation' => 'or',
					'terms'    => array(
					  array(
						'name'     => 'style',
						'operator' => '==',
						 'value'   => 'box',
					  ),
					  array(
						'name'     => 'style',
						'operator' => '==',
						'value'    => 'specialgrid5',
					  ),
					  array(
						'name'     => 'style',
						'operator' => '==',
						'value'    => 'specialgrid6',
					  ),
					)
				),
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 800,
						'step' => 1,
					]
				],
				'default' => [
					'unit' => 'px',
					'size' => 250,
				],
				'selectors' => [
					'{{WRAPPER}} .elpt-portfolio-content.elpt-portfolio-style-box .portfolio-item' => 'height: {{SIZE}}{{UNIT}};',
					//Justified 1
					'{{WRAPPER}} .elpt-portfolio-content.elpt-portfolio-special-grid-5 .portfolio-item-wrapper' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elpt-portfolio-content.elpt-portfolio-special-grid-5 .portfolio-item' => 'height: {{SIZE}}{{UNIT}};',
					//Justified 2
					'{{WRAPPER}} .elpt-portfolio-content.elpt-portfolio-special-grid-6 .portfolio-item-wrapper' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .elpt-portfolio-content.elpt-portfolio-special-grid-6 .portfolio-item' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		//Upgrade message for free version		
		if ( !pe_fs()->can_use_premium_code__premium_only() ) {

			$this->add_control(
				'Upgrade_note2',
				[
					'label' => '',
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => get_upgrade_message(),
					'content_classes' => 'your-class',
				]
			);
		}

		$this->end_controls_section();

		//=========== END - Grid Settings	==============	

		//=========== Hover Settings	==============	
		$this->start_controls_section(
			'section_hover',
			[
				'label' => __( 'Hover Effect Settings', 'powerfolio' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);	

		//PRO Version Snippet
		if ( pe_fs()->can_use_premium_code__premium_only() ) {
			$description = '';
		} else {
			$description = __('Upgrade your plan to get access to 15+ hover effects! <a href="https://checkout.freemius.com/mode/dialog/plugin/7226/plan/12571/">CLICK TO UPGRADE</a>', 'powerfolio');
		}
		if ( pe_fs()->can_use_premium_code__premium_only() ) {
			$this->add_control(
				'hover',
				[
					'label' => __( 'Hover Style', 'powerfolio' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'simple',
					'options' => [
						'simple' => __( 'Simple', 'powerfolio' ),
						'hover1' => __( 'From Bottom', 'powerfolio' ),	
						'hover2' => __( 'From Top', 'powerfolio' ),	
						'hover3' => __( 'From Right', 'powerfolio' ),	
						'hover4' => __( 'From Left', 'powerfolio' ),	
						'hover5' => __( 'Hover Effect 5', 'powerfolio' ),	
						//'hover6' => __( 'Special 1', 'powerfolio' ),	
						'hover7' => __( 'Text from Left', 'powerfolio' ),		
						'hover8' => __( 'Text from right', 'powerfolio' ),	
						'hover9' => __( 'Text from Top', 'powerfolio' ),		
						'hover10' => __( 'Text from Bottom', 'powerfolio' ),
						'hover11' => __( 'Zoom Out', 'powerfolio' ),		
						'hover12' => __( 'Card from Left', 'powerfolio' ),	
						'hover13' => __( 'Card from Right', 'powerfolio' ),	
						'hover14' => __( 'Card from Bottom', 'powerfolio' ),
						'hover15' => __( 'Black and White', 'powerfolio' ),
					]
				]
			);
		} else {
			$this->add_control(
				'hover',
				[
					'label' => __( 'Hover Style', 'powerfolio' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'simple',
					'description' => $description,
					'options' => [
						'simple' => __( 'Simple', 'powerfolio' ),
						'hover1' => __( 'From Bottom', 'powerfolio' ),	
						'hover2' => __( 'From Top', 'powerfolio' ),		
						//'hover15' => __( 'Black and White', 'powerfolio' ),					
					]
				]
			);
		}
		// END - PRO Version Snippet

		$this->add_control(
			'linkto',
			[
				'label' => __( 'Each project links to', 'powerfolio' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'project',
				'options' => [
					'image' => __( 'Featured Image into Lightbox', 'powerfolio' ),
					'project' => __( 'Project Details Page', 'powerfolio' ),				]
			]
		);

		//PRO Version Snippet
		if ( pe_fs()->can_use_premium_code__premium_only() ) {
			//Zoom Effect
			$this->add_control(
				'zoom_effect',
				[
					'label' => __( 'Zoom Effect on Hover', 'powerfolio' ),
					'type' => \Elementor\Controls_Manager::SWITCHER,
					'label_on' => __( 'On', 'powerfolio' ),
					'label_off' => __( 'Off', 'powerfolio' ),
					'return_value' => 'zoom_effect',
					'default' => 'label_off',
				]
			);
		}
		// END - PRO Version Snippet

		//Upgrade message for free version		
		if ( !pe_fs()->can_use_premium_code__premium_only() ) {

			$this->add_control(
				'Upgrade_note3',
				[
					'label' => '',
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => get_upgrade_message(),
					'content_classes' => 'your-class',
				]
			);
		}
		//=========== END - Grid Settings	==============	
		
		$this->end_controls_section();

		//=========== ADVANCED SECTION	==============	
		$this->start_controls_section(
			'section_advanced',
			[
				'label' => __( 'Advanced', 'powerfolio' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);	

		$this->add_control(
			'custom_js',
			[
				'label' => __( 'Custom JS', 'powerfolio' ),
				'type' => \Elementor\Controls_Manager::CODE,
				'language' => 'javascript',
				'rows' => 20,
			]
		);

		//Upgrade message for free version		
		if ( !pe_fs()->can_use_premium_code__premium_only() ) {

			$this->add_control(
				'upgrade_note4',
				[
					'label' => '',
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => get_upgrade_message(),
					'content_classes' => 'your-class',
				]
			);
		}
		

		$this->end_controls_section();
		//=========== END - ADVANCED SECTION	==============	

		//==========================================================================================

		$this->start_controls_section(
			'section_item_description',
			[
				'label' => __( 'Item', 'powerfolio' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		//Hover: Background color
		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'bgcolor',
				'label' => __( 'Hover: Background Color', 'powerfolio' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .portfolio-item-infos-wrapper',
			]
		);

		if ( !pe_fs()->can_use_premium_code__premium_only() ) {

			$this->add_control(
				'Upgrade_note8',
				[
					'label' => '',
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => get_upgrade_message(),
					'content_classes' => 'your-class',
				]
			);
		}

		
		//PRO Version Snippets
		if ( pe_fs()->can_use_premium_code__premium_only() ) {
			
			//Item Title - Typography
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'item_title_typo',
					'label' => __( 'Item Description:  Typography of Title', 'powerfolio' ),
					//'scheme' => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .elpt-portfolio-content .portfolio-item-title',
				]
			);

			//Item Tag - Typography
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'item_tag_typo',
					'label' => __( 'Item Description:  Typography of Category', 'powerfolio' ),
					//'scheme' => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .elpt-portfolio-content .portfolio-item-category',
				]
			);

			//Text Transform
			$this->add_control(
				'text_transform',
				[
					'label' => __( 'Item Description: Text Transform', 'powerfolio' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => __( 'None', 'powerfolio' ),
						'uppercase' => __( 'UPPERCASE', 'powerfolio' ),
						'lowercase' => __( 'lowercase', 'powerfolio' ),
						'capitalize' => __( 'Capitalize', 'powerfolio' ),
					],
					'selectors' => [
						'{{WRAPPER}} .portfolio-item-infos-wrapper' => 'text-transform: {{VALUE}};',
					],
				]
			);	

			//Text Aligment
			$this->add_control(
				'text_align',
				[
					'label' => __( 'Item Description: Text Align', 'powerfolio' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'center' => __( 'Center', 'powerfolio' ),
						'left' => __( 'Left', 'powerfolio' ),
						'right' => __( 'Right', 'powerfolio' ),
					],
					'selectors' => [
						'{{WRAPPER}} .portfolio-item-infos-wrapper' => 'text-align: {{VALUE}};',
					],
				]
			);

			$this->add_control(
				'vertical_align',
				[
					'label' => __( 'Item Description: Vertical Align', 'powerfolio' ),
					'type' => Controls_Manager::SELECT,
					'default' => '50%',
					'options' => [
						'60px' => __( 'Top', 'powerfolio' ),
						'50%' => __( 'Center', 'powerfolio' ),
						'70%' => __( 'Bottom', 'powerfolio' ),
					],
					'selectors' => [
						'{{WRAPPER}} .elpt-portfolio-content .portfolio-item-infos' => 'top: {{VALUE}};',
					],
				]
			);

			//Border Radius
			$this->add_control(
				'border_radius',
				[
					'label' => __( 'Item: Border Radius', 'powerfolio' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ '%' ],
					'range' => [
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => 0,
					],
					'selectors' => [
						'{{WRAPPER}} .elpt-portfolio-content .portfolio-item' => 'border-radius: {{SIZE}}{{UNIT}};',
						//'{{WRAPPER}} .elpt-portfolio-content .portfolio-item img' => 'border-radius: {{SIZE}}{{UNIT}};',
					],
				]
			);
		}
		// END - PRO Version Snippets
		
		//Upgrade message for free version		
		if ( !pe_fs()->can_use_premium_code__premium_only() ) {

			$this->add_control(
				'upgrade_note5',
				[
					'label' => '',
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => get_upgrade_message(),
					'content_classes' => 'your-class',
				]
			);
		}
		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Filter', 'powerfolio' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		//PRO Version Snippets
		if ( pe_fs()->can_use_premium_code__premium_only() ) {

			//Filter- Typography
			$this->add_group_control(
				\Elementor\Group_Control_Typography::get_type(),
				[
					'name' => 'filter_typo',
					'label' => __( 'Filter:  Typography', 'powerfolio' ),
					//'scheme' => Scheme_Typography::TYPOGRAPHY_1,
					'selector' => '{{WRAPPER}} .elpt-portfolio-filter .portfolio-filter-item',
				]
			);


			//Filter: Background color
			$this->add_control(
				'filter_bgcolor',
				[
					'label' => __( 'Filter: Background Color', 'powerfolio' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'alpha' => true,				
					'selectors' => [
						'{{WRAPPER}} .elpt-portfolio-filter .portfolio-filter-item' => 'background-color: {{VALUE}};',
					],
				]
			);

			//Filter: Background color
			$this->add_control(
				'filter_bgcolor_active',
				[
					'label' => __( 'Filter: Background Color (active item)', 'powerfolio' ),
					'type' => Controls_Manager::COLOR,
					'default' => '',
					'alpha' => true,				
					'selectors' => [
						'{{WRAPPER}} .elpt-portfolio-filter .portfolio-filter-item.item-active' => 'background-color: {{VALUE}};',
					],
				]
			);		

			//Filter: Text Transform
			$this->add_control(
				'filter_text_transform',
				[
					'label' => __( 'Filter: Text Transform', 'powerfolio' ),
					'type' => Controls_Manager::SELECT,
					'default' => '',
					'options' => [
						'' => __( 'None', 'powerfolio' ),
						'uppercase' => __( 'UPPERCASE', 'powerfolio' ),
						'lowercase' => __( 'lowercase', 'powerfolio' ),
						'capitalize' => __( 'Capitalize', 'powerfolio' ),
					],
					'selectors' => [
						'{{WRAPPER}} .elpt-portfolio-filter .portfolio-filter-item' => 'text-transform: {{VALUE}};',
					],
				]
			);	
		}
		// END - PRO Version Snippets	

		//Upgrade message for free version		
		if ( !pe_fs()->can_use_premium_code__premium_only() ) {

			$this->add_control(
				'Upgrade_note6',
				[
					'label' => '',
					'type' => \Elementor\Controls_Manager::RAW_HTML,
					'raw' => get_upgrade_message(),
					'content_classes' => 'your-class',
				]
			);
		}

		$this->end_controls_section();		
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$pro_version = true; //pe_fs()->can_use_premium_code__premium_only();
		
		$settings = $this->get_settings();
		?>			

		<?php //echo do_shortcode('[elemenfolio postsperpage="'.$settings['postsperpage'] .'" showfilter="'.$settings['showfilter'].'" style="'.$settings['style'].'" margin="'.$settings['margin'].'" columns="'.$settings['columns'].'" linkto="'.$settings['linkto'].'"]'); ?>
		
		<?php
		//PRO Version Snippets
		if ( pe_fs()->can_use_premium_code__premium_only() ) {
			echo do_shortcode('[powerfolio hover="'.$settings['hover'].'" zoom_effect="'.$settings['zoom_effect'].'" postsperpage="'.$settings['postsperpage'].'" type="'.$settings['type'].'" taxonomy="'.$settings['taxonomy'].'" post_type="'.$settings['post_type'].'" showfilter="'.$settings['showfilter'].'"  tax_text="'.$settings['tax_text'].'" style="'.$settings['style'].'" margin="'.$settings['margin'].'" columns="'.$settings['columns'].'" linkto="'.$settings['linkto'].'"]'); 		
		} else {
			echo do_shortcode('[powerfolio hover="'.$settings['hover'].'" postsperpage="'.$settings['postsperpage'] .'" showfilter="'.$settings['showfilter'].'" tax_text="'.$settings['tax_text'].'" style="'.$settings['style'].'" margin="'.$settings['margin'].'" columns="'.$settings['columns'].'" linkto="'.$settings['linkto'].'"]');
		}?>		

		<?php wp_reset_postdata(); ?>	

		<script><?php echo $settings['custom_js']; ?></script>
			

		<?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	/*protected function _content_template() {
		$sliderheight = $settings['slider_height'];
		?>
		
		<div class="pando-slideshow">
			<?php echo do_shortcode('[pando-slider heightstyle="'.$sliderheight.'"]'); ?>
		</div>


		<?php
	}*/
}
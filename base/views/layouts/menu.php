    		<?php

			 if(isset(Yii::app()->user->id) && isset(Yii::app()->user->dept)) {

			/*$cats=Categories::model()->findAll();
			$mitems = array();
			for($l=0; $l<count($cats); $l++)
				$mitems[]=array('label'=>$cats[$l]->name, 'url'=>array('budgetitems/create&cat='.$cats[$l]->id));
			*/
			$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Registers', 'url'=>array('#'),
				'items'=>
					array(
            		//array('label'=>'Employees', 			'url'=>array('employees/create','emp'=>'new'),'visible'=>is_hr()),
						array('label'=>'Employees', 						'url'=>array('employees/create','emp'=>'extra'),'visible'=>is_hr()),
            			//array('label'=>'Item Registration', 'url'=>array('items/create'),'visible'=>is_sys_admin()),
						//array('label'=>'Item Prices',	 'url'=>array('itemsPrices/create'),'visible'=>is_sys_admin()),
						array('label'=>'Item Registration',	 'url'=>array('items/update'),'visible'=>(is_sys_admin()|| is_finance_officer())),
						array('label'=>'Budget Caps',	 'url'=>array('budgetCaps/create'),'visible'=>is_finance_officer()),
						array('label'=>'Vehicles', 			'url'=>array('vehicles/create'),'visible'=>is_transport_officer()),
						array('label'=>'Vehicle Categories', 			'url'=>array('vehicletypes/admin'),'visible'=>is_transport_officer())
        			),'visible'=>(is_hr() || is_sys_admin() || is_transport_officer()|| is_finance_officer()),

				'linkOptions'=>array('onclick'=>'return false'),
				),
				array('label'=>'Expenses', 'url'=>array('#'),
				'items'=>
					array(
						array('label'=>'Emolument Rates', 	'url'=>array('emolumentrates/create'),'visible'=>is_budget_officer()),
						array('label'=>'Training', 			'url'=>array('travel/create','m'=>'TrainingTravel'),'visible'=>is_budget_officer()),
						array('label'=>'Foreign Travel',		'url'=>array('travel/create','m'=>'ForeignTravel'),'visible'=>is_budget_officer()),
						array('label'=>'Other Staff Costs', 	'url'=>array('staffCosts/create','ac'=>41),'visible'=>is_budget_officer()),
						array('label'=>'__','url'=>'#','linkOptions'=>array('onclick'=>'return false')),
						array('label'=>'General Expenses', 'url'=>array('staffCosts/create','ac'=>45)),
            				array('label'=>'Transport', 					'url'=>array('transportBudget/create'),'visible'=>is_transport_officer()),
						array('label'=>'Other Vehicle Costs',	'url'=>array('staffCosts/create','ac'=>43),'visible'=>is_budget_officer() || is_transport_officer()),
						array('label'=>'Repairs & Maintenaince',	'url'=>array('staffCosts/create','ac'=>44),'visible'=>is_budget_officer()),
						array('label'=>'Operational Subsistence', 'url'=>array('subsistence/create'),'visible'=>is_budget_officer()),
            				array('label'=>'Capital Expenditure',		'url'=>array('staffCosts/create','ac'=>10),'visible'=>is_budget_officer()),
						array('label'=>'Finance Charges', 	'url'=>array('staffCosts/create','ac'=>47),'visible'=>is_legal_officer()),
            				array('label'=>'Depreciation', 				'url'=>array('staffCosts/create','ac'=>46),'visible'=>is_finance_officer()),
						array('label'=>'Bank Guarantees', 			'url'=>array('guaranteesBudget/create'),'visible'=>is_finance_officer()),
        				),'linkOptions'=>array('onclick'=>'return false'),'visible'=>(is_budget_officer())
				),
				array('label'=>'Revenue', 'url'=>array('#'),
				'items'=>
					array(
					//	array('label'=>'Other Income', 			'url'=>array('otherIncome/create')),
						array('label'=>'Energy Sales',			'url'=>array('revenue/create')),
            				array('label'=>'Energy Purchases', 		'url'=>array('revenue/createcosts')),
						array('label'=>'Revenue Requirement', 	'url'=>array('revenue/revenuerequirement')),
						array('label'=>'--', 	'url'=>array('#')),
						array('label'=>'P&L Statement', 	'url'=>array('revenue/pl')),
						array('label'=>'O&M Budget', 	'url'=>array('site/reports&p=costcentres2&old=1')),
					),
				'linkOptions'=>array('onclick'=>'return false'),'visible'=>(is_finance_officer() || is_manager_finance() || is_sys_admin())
				),
				array('label'=>'Budget Check', 'url'=>array('#'),
				'items'=>
					array(
						array('label'=>'Reports', 'url'=>array('bcItembudgets/admin'),'visible'=>(is_proc_officer() or is_manager_finance() or is_sys_admin() or is_sat() or is_pbfo())),
						array('label'=>'Account Items', 'url'=>array('bcItembudgets/accountcodes')),
        				),'linkOptions'=>array('onclick'=>'return false'),
				),
				array('label'=>'Reports', 'url'=>array('#'),
				'items'=>
					array(
      					array('label'=>'Dept Summary', 	'url'=>array('site/reports&p=sum&old=1'),'visible'=>(is_dept_head() || is_manager_finance() || is_finance_officer() || is_sys_admin())),
						array('label'=>'Cost Centre Summary', 		'url'=>array('site/reports&p=costcentres&old=1')),
						array('label'=>'Full Report', 				'url'=>array('site/reports&p=all'),'onclick'=>'alert(\'hi\');'),
						array('label'=>'__', 		'url'=>array('#'),'onclick'=>'return false'),
            				array('label'=>'Staff Emoluments', 		'url'=>array('site/reports&p=40')),
						array('label'=>'Other Staff Costs',		'url'=>array('site/reports&p=41')),
            				array('label'=>'Transport', 				'url'=>array('site/reports&p=42')),
						array('label'=>'Admin Expenses', 		'url'=>array('site/reports&p=45')),
            				array('label'=>'Repairs/Maintainace', 	'url'=>array('site/reports&p=44')),
						array('label'=>'Capital Items', 			'url'=>array('site/reports&p=10')),
						array('label'=>'Depreciation', 			'url'=>array('site/reports&p=46')),
            				array('label'=>'Finance Charges', 		'url'=>array('site/reports&p=47')),
						array('label'=>'__', 		'url'=>array('#'),'onclick'=>'return false'),
						array('label'=>'Energy Purchases', 		'url'=>array('site/reports&p=31'),'visible'=>(is_dept_head() || is_manager_finance() || is_finance_officer() || is_sys_admin())   ),
						//array('label'=>'Energy Sales', 		'url'=>array('site/reports&p=30'),'visible'=>(is_dept_head() || is_manager_finance() || is_finance_officer() || is_sys_admin())),
						//array('label'=>'Other Income', 		'url'=>array('site/reports&p=32'),'visible'=>(is_dept_head() || is_manager_finance() || is_finance_officer() || is_sys_admin())),
        			),'linkOptions'=>array('onclick'=>'return false'),
				),
				array('label'=>'M/Y Reports', 'url'=>array('#'),
				'items'=>
					array(
	      					array('label'=>'Dept Summary', 	'url'=>array('site/reports&p=sum_my&old=1'),'visible'=>(is_dept_head() || is_manager_finance() || is_finance_officer() || is_sys_admin())),
	      					array('label'=>'Cost Centre Summary', 	'url'=>array('site/reports&p=costcentres_my&old=1'),'visible'=>(is_dept_head() || is_manager_finance() || is_finance_officer() || is_sys_admin())),
        			),'visible'=>(is_dept_head() || is_manager_finance() || is_finance_officer() || is_sys_admin()),'linkOptions'=>array('onclick'=>'return false'),
				),

				array('label'=>'Admin', 'url'=>array('#'),
				'items'=>
					array(
						array('label'=>'Settings', 	'url'=>array('settings/admin'),'visible'=>(is_sys_admin())),
						array('label'=>'Users', 			'url'=>array('users/admin'),'visible'=>(is_sys_admin())),
						array('label'=>'User Roles', 		'url'=>array('usersRoles/admin')),
						array('label'=>'Designations', 	'url'=>array('designations/admin')),
						array('label'=>'Departments', 	'url'=>array('dept/admin')),
						array('label'=>'Sections', 		'url'=>array('sections/admin')),
						array('label'=>'Sub Sections', 	'url'=>array('subsections/admin')),
						array('label'=>'__', 		'url'=>array('#'),'onclick'=>'return false'),
						array('label'=>'Merge Section Budgets', 	'url'=>array('settings/move1')),
						array('label'=>'Post Budget Addition', 	'url'=>array('settings/budgetaddition')),
        			),'visible'=>is_sys_admin(),'linkOptions'=>array('onclick'=>'return false'),

				),


			),
		));

		}
		?>

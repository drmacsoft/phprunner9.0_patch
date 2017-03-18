Runner.controls.EditPersianDate = Runner.extend(Runner.controls.Control,{
	myVal: "value of my Field: ", 
	
	/**
	 * Override constructor
	 * @param {Object} cfg
	 */
	constructor: function( cfg ) {		
		this.addEvent( ["change", "keyup"] );		
		// call parent
		Runner.controls.EditPersianDate.superclass.constructor.call(this, cfg);
		this.myVal = this.getFieldSetting("myVal");
		//$(".apersiann2").pDatepicker();
			
	},
	/**
	 * Clone html for iframe submit
	 * @return {array}
	 */
	getForSubmit: function(){
		if (!this.appearOnPage()){
			return [];
		}
		return [this.valueElem.clone().val(this.getValue())]
	},
	setFocus: function(){
		if (!this.appearOnPage()){
			return [];
		}
		return false;
	}

});

Runner.controls.constants["EditPersianDate"] = "EditPersianDate"; 




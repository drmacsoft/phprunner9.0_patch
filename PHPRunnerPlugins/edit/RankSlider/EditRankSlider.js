Runner.controls.EditRankSlider = Runner.extend(Runner.controls.Control,{
	/**
	 * Override constructor
	 * @param {Object} cfg
	 */
	myVal: "value of my Field: ", 
	constructor: function(cfg){		
		this.addEvent(["change", "keyup"]);		
		// call parent
		Runner.controls.EditRankSlider.superclass.constructor.call(this, cfg);
		this.myVal = this.getFieldSetting("myVal");
		
		//$("#"+this.valContId).datepicker({
			// changeMonth: true,
	          //  changeYear: true
			
			
		//});
		

			
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

Runner.controls.constants["EditRankSlider"] = "EditRankSlider"; 




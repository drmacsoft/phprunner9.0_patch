/**
 * TextArea control class
 */
Runner.controls.EditSignaturePad = Runner.extend( Runner.controls.Control, {
	required: false,
	
	bgColor: '#ffffff',
	
	/**
	 * Override constructor
	 * @param {Object} cfg
	 */
	constructor: function( cfg ) {		
		this.addEvent( ["change", "keyup"] );		
		// call parent
		Runner.controls.EditSignaturePad.superclass.constructor.call( this, cfg );
		
		this.required = this.getFieldSetting("required");
		this.bgColor = this.getFieldSetting("bgColor");
		
		if ( this.required ) {
			this.addValidation("IsRequired");
		}
		
		$('.sigPad').signaturePad({
			drawOnly: true, 
			bgColour: this.bgColor
		});
	},
	
	isEmpty: function() {
		return this.getValue().toString() == "";
	},
	
	/**
	 * Clone html for iframe submit
	 * @return {array}
	 */
	getForSubmit: function() {
		if ( !this.appearOnPage() ) {
			return [];
		}
		return [ this.valueElem.clone().val( this.getValue() ) ];
	}
});

Runner.controls.constants["EditSignaturePad"] = "EditSignaturePad"; 




<?php
class ViewPersianDateField extends ViewControl
{
	static function init()
	{}
	
	public function showDBValue(&$data, $keylink)
	{
		return $this->getTextValue( $data );
	}
	
	/**
	 * Get the field's content that will be exported
	 * @prarm &Array data
	 * @prarm String keylink
	 * @return String
	 */
	public function getExportValue(&$data, $keylink = "")
	{
##if @ext == "aspx"##
		return $data[ $this->field ];
##endif##	
		return $this->showDBValue($data, $keylink);
	}

	/**
	 * @param &Array data
	 * @return String	 
	 */
	public function getTextValue(&$data)
	{
		return format_persiandate( db2time( $data[ $this->field ] ) );
	}
}

?>
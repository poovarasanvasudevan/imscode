<?php 
class ModelShippingDistance extends Model {    
  	public function getDistance($fromPincode, $toPincode) {
	    $url = "http://maps.googleapis.com/maps/api/distancematrix/xml?origins=INDIA+" . $fromPincode . "&destinations=INDIA+" . $toPincode . "&units=imperial&sensor=false";
	    	    
		//@ Get the xml document
		$xmlDoc = $this->SendRequest($url, 'POST', array('origins' => 'INDIA'));
		
		$xml = simplexml_load_string($xmlDoc);
		
		foreach ($xml->row as $value){
			$dist1 =  $value->element->distance->text;
		}
		
		$dist2 = intval(preg_replace('/,/', '', $dist1));
		
		$milesToKm = 1.609344;
		$distance = $milesToKm * $dist2;
		return $distance;
	}
	
	function SendRequest( $url, $method = 'GET', $data = array(), $headers = array('Content-type: application/x-www-form-urlencoded') )
	{
		$context = stream_context_create(array
				(
						'http' => array(
								'method' => $method,
								'header' => $headers,
								'content' => http_build_query( $data )
						)
				));
	
		return file_get_contents($url, false, $context);
	}
	
	private function initStatus($status) {
		if ($status != null && is_object($status)) {
			$this->status = new TransactionStatus();
			$reflector = new ReflectionClass('TransactionStatus');
			$properties = $reflector->getProperties();
	
			foreach ($properties as $property) {
				if (isset($status->{$property->getName()})) {
					$this->status->{"set" . ucfirst($property->getName())}($status->{$property->getName()});
				}
			}
		}
	}
	
	function parseSimpleXML($xmldata)
	{
		$childNames = array();
		$children = array();
	
		if( $xmldata->count() !== 0 )
		{
			foreach( $xmldata->children() AS $child )
			{
				$name = $child->getName();
	
				if( !isset($childNames[$name]) )
				{
					$childNames[$name] = 0;
				}
	
				$childNames[$name]++;
				$children[$name][] = $this->parseSimpleXML($child);
			}
		}
	
		$returndata = new XMLNode();
		if( $xmldata->attributes()->count() > 0 )
		{
			$returndata->{'@attributes'} = new XMLAttribute();
			foreach( $xmldata->attributes() AS $name => $attrib )
			{
				$returndata->{'@attributes'}->{$name} = (string)$attrib;
			}
		}
	
		if( count($childNames) > 0 )
		{
			foreach( $childNames AS $name => $count )
			{
				if( $count === 1 )
				{
					$returndata->{$name} = $children[$name][0];
				}
				else
				{
					$returndata->{$name} = new XMLMultiNode();
					$counter = 0;
					foreach( $children[$name] AS $data )
					{
						$returndata->{$name}->{$counter} = $data;
						$counter++;
					}
				}
			}
		}
		else
		{
			if( (string)$xmldata !== '' )
			{
				$returndata->{'@innerXML'} = (string)$xmldata;
			}
		}
		return $returndata;
	}
}
?>
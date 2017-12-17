<?php 

namespace THY;

/**
 * @author Mustafa KÜÇÜK
 *
 * Turkish Airlines API Class
 * API URL : https://developer.turkishairlines.com
 * API Doumantion : https://developer.turkishairlines.com/documentation 
 */

class THYAPI
{

  const API_URL = "https://api.turkishairlines.com/test/";
  private $apiKey;
  private $apiSecret;

  public function __construct( $config ){
     if( is_array($config) ){
      $this->apiKey = $config["apiKey"];
      $this->apiSecret = $config["apiSecret"];
     }
  }

  /**
   * @param boolean $ReducedDataIndicator - Default ‘false’ If it is true, prices are not returned in response, only availability
   * @param string $RoutingType - ‘O’ for one way ‘R’ for round trip ‘M’ for multicity
   * @param string $TargetSource [optional] - If it is award ticket request, this should be added to request
   *
   * PassengerTypeQuantity
   * @param string $Code - PassengerType Code (adult, child, infant)
   * @param int $Quantity - Number of that passenger type
   *
   * OriginDestinationInformation.DepartureDateTime
   * @param string $WindowAfter - How many days should be return after departure date. (If it is P3D, 3 days of availability will be returned briefly. If it is P0D, only that day in departureDateTime will be returned with all flights.)
   * @param string $WindowBefore - How many days should be return before departure date. (If it is P3D, 3 days of availability before DepartureDateTime will be returned briefly. If it is P0D, only that day in departureDateTime will be returned with all flights.)
   * @param string $Date - Departure day and month EX: "14OCT"
   *
   * OriginDestinationInformation.OriginLocation
   * @param string $LocationCode - IATA portcode
   * @param boolean $MultiAirportCityInd - If that city has more than one airport, this should be set as true to get flights departing from all airports in that city.
   *
   * OriginDestinationInformation.DestinationLocation
   * @param string $LocationCode - IATA portcode
   * @param boolean $MultiAirportCityInd - If that city has more than one airport, this should be set as true to get flights departing from all airports in that city.
   *
   * OriginDestinationInformation.CabinPreferences
   * @param string(ECONOMY, BUSINESS) $Cabin - Requested cabin type for a flight
   *
   * API Documantion : https://developer.turkishairlines.com/documentation/GetAvailability
   */

  public function getAvailability( $params ){
    if( is_array( $params ) ){
      return $this->doRequest( 'getAvailability', $params, 'POST' );
    }else{
      echo '$params is be array';
    }
  }

  /**
   * @param string(W, M, D) $scheduleType - W for weekly schedule, M for monthly, D for daily
   * @param string(O, R) $tripType - O for one way, R for round trip
   * @param string(YYYY-MM-DD) $returnDate [optional] - O for one way, R for round trip
   *
   * OTA_AirScheduleRQ
   * @param string $AirlineCode [optional] - 2-letter airline code
   *
   * OTA_AirScheduleRQ.OriginDestinationInformation.DepartureDateTime
   * @param string(YYYY-MM-DD) $Date - Departure day and month   
   * @param string(P0D, P3D) $WindowAfter - How many days should be return after departure date. (If it is P3D, 3 days of schedule will be returned briefly. If it is P0D, only that day in departureDateTime will be returned with all flights.)
   * @param string(P0D, P3D) $WindowBefore - How many days should be return before departure date. (If it is P3D, 3 days of schedule before DepartureDateTime will be returned briefly. If it is P0D, only that day in departureDateTime will be returned with all flights.
   *
   * OTA_AirScheduleRQ.OriginDestinationInformation.OriginLocation
   * @param string $LocationCode - IATA portcode
   * @param boolean $MultiAirportCityInd - If that city has more than one airport, this should be set as true to get flights departing from all airports in that city.
   *
   * OTA_AirScheduleRQ.OriginDestinationInformation.DestinationLocation
   * @param string $LocationCode - IATA portcode
   * @param boolean $MultiAirportCityInd - If that city has more than one airport, this should be set as true to get flights departing from all airports in that city.   
   */
  public function getTimeTable(){
    if( is_array( $params ) ){
      return $this->doRequest( 'getTimeTable', $params, 'POST' );
    }else{
      echo '$params is be array';
    }    
  }

  /**
   * @param string $airlineCode - Get ports for only this airline
   * @param string $languageCode [optioanal] - Get ports in particular language
   *
   * API Documantion : https://developer.turkishairlines.com/documentation/getPortList
   */
  public function getPortList( $airlineCode, $languageCode = '' ){
    return $this->doRequest( 'getPortList', array( 'airlineCode' => $airlineCode, 'languageCode' => $languageCode ), 'GET' );
  }

  /**
   * @param string $portList - Array of 3 Letter IATA Port code
   * @param string $isMilesRequest [optional] - If availability req is for award ticket, this parameter should be set as ‘true’. Ex: "T" or "F"
   *
   * API Documantion : https://developer.turkishairlines.com/documentation/getFareFamilyList
   */
  public function getFareFamilyList( $portList, $isMilesRequest = '' ){
   return $this->doRequest( 'getFareFamilyList', array( 'portList' => $portList, 'isMilesRequest' => $isMilesRequest ), 'POST' );
  }

  /**
   * @param string $UniqueId    Reservation number generated by reservation system
   * @param string $Surname     The surname of any passenger in the reservation
   *
   * API Documantion : https://developer.turkishairlines.com/documentation/retrieveReservationDetail
   */
  public function retrieveReservationDetail( $UniqueId, $Surname ){
    return $this->doRequest( 'retrieveReservationDetail', array( 'UniqueId' => $UniqueId, 'Surname' => $Surname ), 'GET' );
  }

  /**
   * @param string $origin - 3 digits code City
   * @param string $destination - The surname of any passenger in the reservation
   * @param string $cabin_code [optional] - Cabin Code
   * @param string $class_code [optional] - Class Info
   * @param string $marketingClassCode [optional] - Marketing Class Code
   * @param string $card_type [optional] - Card type
   * @param string $flightDate [optional] - Flight date (DD.MM.YYYY).
   * @param string $operatingFlightNumber [optional] - Operating Flight Number
   * @param string $marketingFlightNumber [optional] - Marketing Flight Number
   *
   * API Documantion : https://developer.turkishairlines.com/documentation/calculate-flight-miles
   */
  public function calculateFlightMiles( $params ){
    if( is_array( $params ) ){
      return $this->doRequest( 'calculateFlightMiles', $params, 'POST' );           
    }else{
      echo '$params is be array';
    }  
  }

  /**
   * @param string $awardType - Award type
   * @param string $wantMoreMiles [optional] - F/T. F: no seatGuaranteed T: seatGuaranteed
   * @param string $isOneWay [optional] - OneWay/Round trip
   * @param string $departureOrigin [optional] - Departure Origin
   * @param string $departureDestination [optional] - Departure Destination
   * @param int $departureDateDay [optional] - Departure Date Day
   * @param int $departureDateMonth [optional] - Departure Date Month
   * @param int $departureDateYear [optional] - Departure Date Year
   * @param string $arrivalOrigin [optional] - Arrival Origin
   * @param string $arrivalDestinaton [optional] - Arrival Destination
   * @param int $arrivalDateDay [optional] - Arrival Date Day
   * @param int $arrivalDateMonth [optional] - Arrival Date Month
   * @param int $arrivalDateYear [optional] - Arrival Date Year
   * @param string $ptcType [optional] - Req infant,child Passenger type FFY,TNN, TNF,FFC
   *
   * API Documantion : https://developer.turkishairlines.com/documentation/calculate-award-miles-with-tax   
   *
   */
  public function calculateAwardMilesWithTax( $params ){
    if( is_array( $params ) ){
      return $this->doRequest( 'calculateAwardMilesWithTax', $params, 'POST' );      
    }else{
      echo '$params is be array';
    }
  }

  protected function doRequest( $action, $params = array(), $method = 'GET' ){
      $paramstoQuery = '?'.http_build_query($params);    
      $requestURL = $this::API_URL.$action.( $method == 'GET' ? $paramstoQuery : null);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $requestURL);
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('apikey:'.$this->apiKey,'apisecret:'.$this->apiSecret, 'Accept: application/json'));
      if( $method == 'POST' ){
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
      }
      $getData = curl_exec($ch);
      curl_close($ch);
      return $getData;     
  }

}

?>
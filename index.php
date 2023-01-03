<?php
class WeatherAPI{
    private  $api_url  ;
    private  $weather_data ;
    //initialization constructor
    function __construct($city_name, $api_key){
        $this->api_url=  "https://api.openweathermap.org/data/2.5/weather?q=".$city_name."&appid=".$api_key;
        $this->weather_data= json_decode(file_get_contents($this->api_url),true) ;
    }
    //User-Defined Function
    public function Convert_To_Celsius($tmp ){
        return $tmp - 273.15;
    }
    public function Convert_To_Fahrenheit($tmp){
        return ((($tmp) - 273.15) * 1.8) + 32;
    }
    public function Convert_Ddegree_to_DText($degree){
        if (degree>337.5) return 'Northerly';
        if (degree>292.5) return 'North Westerly';
        if(degree>247.5) return 'Westerly';
        if(degree>202.5) return 'South Westerly';
        if(degree>157.5) return 'Southerly';
        if(degree>122.5) return 'South Easterly';
        if(degree>67.5) return 'Easterly';
        if(degree>22.5){return 'North Easterly';}
        return 'Northerly';
    }
    //-?get the temperature of the current location
    //-?default return is the Kelvin
    public function getTemperature($tmp_name="kelvin",$type="avg"){
        $temp = null;
        if($type == "max"){
            $temp = "temp_max";
        }else if($type == "min"){
            $temp = "temp_min" ;
        }else {
            $temp = "temp" ;
        }
        $tmp = strtolower(substr($tmp_name, 0, 1)) ;
        switch ($tmp){
            case 'c' : return $this->Convert_To_Celsius($this->weather_data['main'][$temp]);
            case 'f' : return $this->Convert_To_Fahrenheit($this->weather_data['main'][$temp]);
            default:
                return $this->weather_data['main']['temp'];
        }
    }
    public function getWeatherStatus($short=false){
        if($short === true){
            return $this->weather_data["weather"][0]["main"];
        }else{
            return $this->weather_data["weather"][0]["description"];
        }
    }
    public function getWeatherIcon(){
        return $this->weather_data["weather"][0]["icon"] ;
    }
    //Default Return is HPA
    public function getPressure(){
        return $this->weather_data['main']['pressure'];
    }
    //Default Return is percentage;
    public function getHumidity(){
        return $this->weather_data['main']['humidity'] ;
    }
    public function getWindDirection(){
        $degree = $this->weather_data['main']['deg'];
        return $this->Convert_Ddegree_to_DText($degree) ;
    }
    public function GetCloudiness(){
        return $this->weather_data['clouds']['all'];
    }
    public function GetLong(){
        return $this->weather_data['coord']['lon'];
    }
    public function GetLat(){
        return $this->weather_data['coord']['lat'] ;
    }
    // Default return is m/s
    public function getWindSpeed(){
        return $this->weather_data['main']['speed'];
    }
    public function CurrentName(){
        return $this->weather_data['name'];
    }

    public function CurrentID(){
        return $this->weather_data['id'];
    }
    public function getEnvironmentTemperature($tmp_name="kelvin",$type="avg"){
        $temp = null;
        if($type == "max"){
            $temp = "temp_max";
        }else if($type == "min"){
            $temp = "temp_min" ;
        }else {
            $temp = "temp" ;
        }
        $tmp = strtolower(substr($tmp_name, 0, 1)) ;
        switch ($tmp){
            case 'c' : return $this->Convert_To_Celsius($this->weather_data['feels_like'][$temp]);
            case 'f' : return $this->Convert_To_Fahrenheit($this->weather_data['feels_like'][$temp]);
            default:
                return $this->weather_data['feels_like']['temp'];
        }
    }
}




<?php
// Get the user's IP address
$ip_address = $_SERVER['REMOTE_ADDR'];

// Call the ipapi API to get the latitude and longitude for the IP address
$api_url = "https://ipapi.co/$ip_address/json/";
$api_response = file_get_contents($api_url);
$api_data = json_decode($api_response, true);
// try to set latitude, else set lat of Berlin
if (isset($api_data['latitude'])) {
    $latitude = $api_data['latitude'];
} else {
    $latitude = 52.520008;
}
// try to set latitude, else set lon of Berlin
if (isset($api_data['longitude'])) {
    $longitude = $api_data['longitude'];
} else {
    $longitude = 13.404954;
}
// Set the date and timezone
$date = date_create();
$timezone = new DateTimeZone('Europe/Berlin');

// Get the sunrise and sunset times
$sun_info = date_sun_info($date->getTimestamp(), $latitude, $longitude);
?>
<div class="relative w-full bg-blend-multiply">
    <img class="absolute inset-0 object-cover w-full h-full" src="{{header_day.0.url}}" alt="{{header_day.0.alt}}">
    <div class="relative h-full text-black">
        <div class="w-full p-5 py-16 sm:w-7/12 md:w-6/12 xl:w-5/12 lg:py-32 md:py-26">
            <!-- Background div with opacity -->
            <div class="absolute inset-0 z-0 w-full bg-white sm:w-7/12 md:w-6/12 xl:w-5/12 opacity-90"></div>

            <!-- Text content with higher z-index -->
            <div class="relative z-10 w-full">
                <div class="m-auto mb-6 text-center lg:mb-0">
                    <h1 class="mb-4 text-4xl font-bold leading-tight tracking-tight text-black md:text-5xl lg:text-6xl">{{title}}</h1>
                    <p class="mb-6 font-light text-gray-900 md:text-lg lg:mb-8 lg:text-xl">{{subtitle}}</p>
                </div>

                {{partial:subpartials-header/front-page-searchbox}}
                <div class="grid grid-cols-1 space-x-4 space-y-16">
                    <!-- Verkaufen Section - Only show when toggled in backend -->
                    {{if header_seller_content}}
                    {{partial:subpartials-header/front-page-sell}}
                </div>
                {{/if}}
            </div>
        </div>
    </div>
</div>

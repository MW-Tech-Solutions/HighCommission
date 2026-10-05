<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;

class NigeriaController extends Controller {
    public function map(Request $request): void {
        $states = $this->getStatesData();
        $this->render('nigeria/map', ['states' => $states]);
    }

    private function getStatesData(): array {
        return [
            ['name' => 'Abia', 'capital' => 'Umuahia', 'zone' => 'south_east', 'hub' => 'Aba Commercial Hub', 'landmark' => 'Arochukwu Long Juju Slave Route'],
            ['name' => 'Adamawa', 'capital' => 'Yola', 'zone' => 'north_east', 'hub' => 'Yola Agriculture & Livestock', 'landmark' => 'Sukur Cultural Landscape (UNESCO World Heritage)'],
            ['name' => 'Akwa Ibom', 'capital' => 'Uyo', 'zone' => 'south_south', 'hub' => 'Oil & Maritime Gas', 'landmark' => 'Godswill Akpabio International Stadium & Ibeno Beach'],
            ['name' => 'Anambra', 'capital' => 'Awka', 'zone' => 'south_east', 'hub' => 'Onitsha Main Market', 'landmark' => 'Ogbunike Caves'],
            ['name' => 'Bauchi', 'capital' => 'Bauchi', 'zone' => 'north_east', 'hub' => 'Ecotourism & Mining', 'landmark' => 'Yankari Game Reserve & Wikki Warm Springs'],
            ['name' => 'Bayelsa', 'capital' => 'Yenagoa', 'zone' => 'south_south', 'hub' => 'Petroleum & Aquaculture', 'landmark' => 'Ox-Bow Lake & Peace Park'],
            ['name' => 'Benue', 'capital' => 'Makurdi', 'zone' => 'north_central', 'hub' => 'Food Basket of the Nation', 'landmark' => 'Ikwe Holiday Resort & Benue River Confluence'],
            ['name' => 'Borno', 'capital' => 'Maiduguri', 'zone' => 'north_east', 'hub' => 'Cross-Border Sahelian Commerce', 'landmark' => 'Lake Chad Basin & Shehu of Borno Palace'],
            ['name' => 'Cross River', 'capital' => 'Calabar', 'zone' => 'south_south', 'hub' => 'Carnival & Eco-Forestry', 'landmark' => 'Obudu Mountain Resort & Drill Ranch'],
            ['name' => 'Delta', 'capital' => 'Asaba', 'zone' => 'south_south', 'hub' => 'Oil Refining & Delta Ports', 'landmark' => 'River Niger Bridge & Nana Living History Museum'],
            ['name' => 'Ebonyi', 'capital' => 'Abakaliki', 'zone' => 'south_east', 'hub' => 'Salt & Rice Milling', 'landmark' => 'Unwana Golden Sand Beach'],
            ['name' => 'Edo', 'capital' => 'Benin City', 'zone' => 'south_south', 'hub' => 'Bronze Casting & Creative Arts', 'landmark' => 'Royal Palace of the Oba of Benin & National Museum'],
            ['name' => 'Ekiti', 'capital' => 'Ado-Ekiti', 'zone' => 'south_west', 'hub' => 'Knowledge & Agricultural Technology', 'landmark' => 'Ikogosi Warm & Cold Springs Confluence'],
            ['name' => 'Enugu', 'capital' => 'Enugu', 'zone' => 'south_east', 'hub' => 'Coal City & Tech Innovation', 'landmark' => 'Awhum Waterfall & Udi Hills'],
            ['name' => 'FCT Abuja', 'capital' => 'Abuja', 'zone' => 'north_central', 'hub' => 'Federal Capital & Diplomacy', 'landmark' => 'Zuma Rock, Aso Rock & National Mosque'],
            ['name' => 'Gombe', 'capital' => 'Gombe', 'zone' => 'north_east', 'hub' => 'Jewel in the Savannah Trade', 'landmark' => 'Bima Hill & Tangale Peak'],
            ['name' => 'Imo', 'capital' => 'Owerri', 'zone' => 'south_east', 'hub' => 'Hospitality & Education', 'landmark' => 'Oguta Lake Resort & Mbari Cultural Centre'],
            ['name' => 'Jigawa', 'capital' => 'Dutse', 'zone' => 'north_west', 'hub' => 'Sesame & Groundnut Belt', 'landmark' => 'Dutse Rock Formations & Birnin Kudu Rock Paintings'],
            ['name' => 'Kaduna', 'capital' => 'Kaduna', 'zone' => 'north_west', 'hub' => 'Textiles & Industrial Manufacturing', 'landmark' => 'Kajuru Castle & Nok Culture Museum'],
            ['name' => 'Kano', 'capital' => 'Kano', 'zone' => 'north_west', 'hub' => 'Kano Ancient City Market', 'landmark' => 'Emir of Kano Palace & Kurmi Market'],
            ['name' => 'Katsina', 'capital' => 'Katsina', 'zone' => 'north_west', 'hub' => 'Cotton & Trans-Saharan Trade', 'landmark' => 'Gobarau Minaret & Emir Palace'],
            ['name' => 'Kebbi', 'capital' => 'Birnin Kebbi', 'zone' => 'north_west', 'hub' => 'Argungu Fishing & Rice', 'landmark' => 'Argungu International Fishing Festival Site'],
            ['name' => 'Kogi', 'capital' => 'Lokoja', 'zone' => 'north_central', 'hub' => 'Confluence State Iron Ore', 'landmark' => 'Niger-Benue Confluence & Lord Lugard Residence'],
            ['name' => 'Kwara', 'capital' => 'Ilorin', 'zone' => 'north_central', 'hub' => 'Pottery & Sugar Agro-allied', 'landmark' => 'Owu Waterfall & Esie Museum'],
            ['name' => 'Lagos', 'capital' => 'Ikeja', 'zone' => 'south_west', 'hub' => 'West Africa Economic Megacity', 'landmark' => 'Lekki Conservation Centre, Eko Atlantic & National Theatre'],
            ['name' => 'Nasarawa', 'capital' => 'Lafia', 'zone' => 'north_central', 'hub' => 'Solid Minerals & Agriculture', 'landmark' => 'Farin Ruwa Waterfalls'],
            ['name' => 'Niger', 'capital' => 'Minna', 'zone' => 'north_central', 'hub' => 'Hydroelectric Energy Generation', 'landmark' => 'Kainji Lake National Park & Gurara Falls'],
            ['name' => 'Ogun', 'capital' => 'Abeokuta', 'zone' => 'south_west', 'hub' => 'Gateway Industrial Hub', 'landmark' => 'Olumo Rock & Adire Textile Market'],
            ['name' => 'Ondo', 'capital' => 'Akure', 'zone' => 'south_west', 'hub' => 'Cocoa & Bitumen', 'landmark' => 'Idanre Hills (UNESCO World Heritage Site)'],
            ['name' => 'Osun', 'capital' => 'Osogbo', 'zone' => 'south_west', 'hub' => 'Heritage & Gold Mining', 'landmark' => 'Osun-Osogbo Sacred Grove (UNESCO World Heritage)'],
            ['name' => 'Oyo', 'capital' => 'Ibadan', 'zone' => 'south_west', 'hub' => 'Pacesetter Commerce & Education', 'landmark' => 'Cocoa House & Agodi Gardens'],
            ['name' => 'Plateau', 'capital' => 'Jos', 'zone' => 'north_central', 'hub' => 'Tin Mining & Horticulture', 'landmark' => 'Shere Hills & Jos Wildlife Park'],
            ['name' => 'Rivers', 'capital' => 'Port Harcourt', 'zone' => 'south_south', 'hub' => 'Garden City Oil & Petrochemicals', 'landmark' => 'Port Harcourt Pleasure Park & Bonny Island'],
            ['name' => 'Sokoto', 'capital' => 'Sokoto', 'zone' => 'north_west', 'hub' => 'Seat of the Caliphate & Leather', 'landmark' => 'Sultan of Sokoto Palace & Hubbare Monument'],
            ['name' => 'Taraba', 'capital' => 'Jalingo', 'zone' => 'north_east', 'hub' => 'Nature State Forestry & Tea', 'landmark' => 'Mambilla Plateau & Kakara Tea Estate'],
            ['name' => 'Yobe', 'capital' => 'Damaturu', 'zone' => 'north_east', 'hub' => 'Gum Arabic & Cattle Trading', 'landmark' => 'Dufuna Canoe (Oldest in Africa)'],
            ['name' => 'Zamfara', 'capital' => 'Gusau', 'zone' => 'north_west', 'hub' => 'Farming & Gold Deposits', 'landmark' => 'Kwatarkwashi Rock & Springs']
        ];
    }
}

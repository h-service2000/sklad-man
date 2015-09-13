<?
$phone="+7 (495) 374-55-24";

$co_place_type1=array();
$co_place_type1[1]="Склад";
$co_place_type1[2]="Морозильный склад";
$co_place_type1[3]="Холодильный склад";
$co_place_type1[4]="Производственное здание";
$co_place_type1[5]="Алкогольный склад";
$co_place_type1[6]="Фармацевтический склад";
$co_place_type1[7]="Открытая площадка";
$co_place_type1[8]="Пищевое производство";
$co_place_type1[9]="Ангар";
$co_place_type1[12]="Овощехранилище";
$co_place_type1[13]="Бетонный завод";
$co_place_type1[14]="Автосервис";
$co_place_type1[15]="Автосалон";


$co_place_type2[1]="участки для строительства торговых центров и магазинов";
$co_place_type2[8]="участки для промышленно-складского строительства";
$co_place_type2[9]="участки сельскохозяйственного назначения, усадьбы и КФХ";
$co_place_type2[2]="участки для многоэтажного и среднеэтажного строительства";
$co_place_type2[3]="участки для малоэтажного,  коттеджно-дачного строительства и ИЖС";
$co_place_type2[4]="участки для объектов рекреации";
$co_place_type2[5]="участки под АЗС, придорожные сервисы и транспортную инфраструктуру";



require_once $_SERVER['DOCUMENT_ROOT']."/irr/dump.lst";
$currency[1]="USD"; $currency[2]="RUB";$currency[3]="EUR";
$co_place_type=$co_place_type1;
$squareField="square-min";$landField="warehouse_type_object";

$R=file_get_contents($_SERVER['DOCUMENT_ROOT']."/irr/pre.src");

$res=qwery("SELECT * FROM `taenf_agent_flat_rent` where `co_publicate`=1",-1);
for($i=0;$i<count($res);$i++){
	if(!strpos($res[$i]['photo_name'],"/realty/ren/".$res[$i]['co_id']."_")) continue;
	$res[$i]['category']='/real-estate/commercial/production-warehouses';
	$q="SELECT * FROM `taenf_agent_lotnum_map` where (`table_id`=".$res[$i]['co_id']." AND `table_name`='flat_rent')";  if(!($id=qwery($q,0))) continue; $id=$id['id'];$res[$i]['ID']=$id;
	$res[$i]['link']='http://sklad-man.com/ru/rent/lotnum-'.$id;
	
	$q="SELECT * FROM `taenf_agent_gallery` WHERE (`item_type`='mod_ren' AND `item_id` =".$res[$i]['co_id'].")"; $res[$i]['gallery']=qwery($q,-1); 
	$q="SELECT * FROM `taenf_agent_users` where `u_id`=".$res[$i]['co_agent_id']; $res[$i]['agent']=qwery($q,0); //co_author_id
	$q="SELECT * FROM `taenf_agent_geobase` WHERE `id` =".$res[$i]['geobase_id'];$res[$i]['geo']=qwery($q,0);
	$path=explode("/",$res[$i]['geo']['path']); array_pop($path);	$q="SELECT * FROM `taenf_agent_geobase` WHERE `id` =".array_pop($path);$res[$i]['geoparent']=qwery($q,0);
	if($res[$i]['h_id']) {$q="SELECT * FROM `taenf_agent_geobase` WHERE `id` =".$res[$i]['h_id'];$res[$i]['road']=qwery($q,0);}
	$res[$i]['agent']['u_phone_work']=$phone;
	$advert=setAdvert($res[$i]); //Dump($advert);
	if($advert) $R.=implode("\n",$advert);
	$res[$i]="";
//	break;
}



$res=qwery("SELECT * FROM `taenf_agent_flat_sell` where `co_publicate`=1",-1);
for($i=0;$i<count($res);$i++){
	if(!strpos($res[$i]['photo_name'],"/realty/fls/".$res[$i]['co_id']."_")) continue;
	$res[$i]['category']='/real-estate/commercial-sale/production-warehouses';
	$q="SELECT * FROM `taenf_agent_lotnum_map` where (`table_id`=".$res[$i]['co_id']." AND `table_name`='flat_sell')";  if(!($id=qwery($q,0))) continue; $id=$id['id'];$res[$i]['ID']=$id;
	$res[$i]['link']='http://sklad-man.com/ru/sell/lotnum-'.$id;
	
	$q="SELECT * FROM `taenf_agent_gallery` WHERE (`item_type`='mod_fls' AND `item_id` =".$res[$i]['co_id'].")"; $res[$i]['gallery']=qwery($q,-1); 
	$q="SELECT * FROM `taenf_agent_users` where `u_id`=".$res[$i]['co_agent_id']; $res[$i]['agent']=qwery($q,0); //co_author_id
	$q="SELECT * FROM `taenf_agent_geobase` WHERE `id` =".$res[$i]['geobase_id'];$res[$i]['geo']=qwery($q,0);
	$path=explode("/",$res[$i]['geo']['path']); array_pop($path);	$q="SELECT * FROM `taenf_agent_geobase` WHERE `id` =".array_pop($path);$res[$i]['geoparent']=qwery($q,0);
	if($res[$i]['h_id']) {$q="SELECT * FROM `taenf_agent_geobase` WHERE `id` =".$res[$i]['h_id'];$res[$i]['road']=qwery($q,0);}
	$res[$i]['agent']['u_phone_work']=$phone;
	$advert=setAdvert($res[$i]); //Dump($advert);
	if($advert) $R.=implode("\n",$advert);
	$res[$i]="";
//	break;
}


$co_place_type=$co_place_type2;
$squareField="land"; $landField="land_usage";

$res=qwery("SELECT * FROM `taenf_agent_zem_objects` where `co_publicate`=1",-1);
for($i=0;$i<count($res);$i++){
	if(!strpos($res[$i]['photo_name'],"/realty/zem/".$res[$i]['co_id']."_")) continue;
	$res[$i]['category']='/real-estate/out-of-town/lands';
	$q="SELECT * FROM `taenf_agent_lotnum_map` where (`table_id`=".$res[$i]['co_id']." AND `table_name`='zem_objects')";  if(!($id=qwery($q,0))) continue; $id=$id['id'];$res[$i]['ID']=$id;
	$res[$i]['link']='http://sklad-man.com/ru/land/lotnum-'.$id;	
	
	$q="SELECT * FROM `taenf_agent_gallery` WHERE (`item_type`='mod_zem' AND `item_id` =".$res[$i]['co_id'].")"; $res[$i]['gallery']=qwery($q,-1); 
	$q="SELECT * FROM `taenf_agent_users` where `u_id`=".$res[$i]['co_agent_id']; $res[$i]['agent']=qwery($q,0); //co_author_id
	$q="SELECT * FROM `taenf_agent_geobase` WHERE `id` =".$res[$i]['geobase_id'];$res[$i]['geo']=qwery($q,0);
	$path=explode("/",$res[$i]['geo']['path']); array_pop($path);	$q="SELECT * FROM `taenf_agent_geobase` WHERE `id` =".array_pop($path);$res[$i]['geoparent']=qwery($q,0);
	if($res[$i]['h_id']) {$q="SELECT * FROM `taenf_agent_geobase` WHERE `id` =".$res[$i]['h_id'];$res[$i]['road']=qwery($q,0);}
	$res[$i]['agent']['u_phone_work']=$phone;
	$res[$i]['co_area']*=100;
	$advert=setAdvert($res[$i]); //Dump($advert);
	if($advert) $R.=implode("\n",$advert);
	$res[$i]="";
//	exit();

}

$R.="\n\t</user>\n</users>";
file_put_contents($_SERVER['DOCUMENT_ROOT']."/irr/adverts.xml",$R);
//file_put_contents($_SERVER['DOCUMENT_ROOT']."/tmp/irr/end.txt","");

echo "OK";


function setAdvert($a){global $currency,$co_place_type,$squareField,$landField; //Dump($a); //exit();

//$T=$a['co_date_add']+3600*24*31*3;
$T=time()+3600*24*31*3;

$a['co_date_add']=time()-3600*24*mt_rand(4,9)-3600*mt_rand(1,24);
$validfrom=date('Y-m-d',$a['co_date_add']).'T'.date('09:00:00',$a['co_date_add']);
$validtill=date('Y-m-d',$T).'T'.date('23:59:59',$T);
$price="договорная"; if(intval($a['co_price1'])) $price=$a['co_price1'];
if(strpos(" ".$a['geoparent']['name_ru'],"Московская")) $a['geoparent']['name_ru']="Московская";
else if(strpos(" ".$a['geoparent']['name_ru'],"Москва")) $a['geoparent']['name_ru']="Москва";

$description=$a['co_add_info']; if(!$description) return;
$description=str_replace('&',' and ',$description);
$description=str_replace("'","`",$description);
if($a['geo']['level']<3) return;

$params=json_decode($a['params']);
$R[]='<store-ad validfrom="'.$validfrom.'" validtill="'.$validtill.'" power-ad="1" source-id="'.$a['ID'].'" category="'.$a['category'].'" >';
$R[]='	<products>';
$R[]='		<product name="premium" type="7" validfrom="'.date('Y-m-d',$a['co_date_add']).'"/>';
$R[]='	</products>';

$R[]='	<price value="'.$price.'" currency="'.$currency[$a['co_currency_id']].'"></price>';
$R[]='	<title>'.$a['co_name'].'</title>';
$R[]='	<description>'.$description.'</description>';
$R[]='	<fotos>';
for($i=0;$i<count($a['gallery']);$i++){
	$link='http://sklad-man.com/'.$a['gallery'][$i]['image'];
	$md=md5(@file_get_contents($_SERVER['DOCUMENT_ROOT']."/".$a['gallery'][$i]['image']));
	$R[]='		<foto-remote url="'.$link.'" md5="'.$md.'"/>';
}
$R[]='	</fotos>';
$R[]='	<custom-fields>';
$R[]='		<field name="region">'.$a['geoparent']['name_ru'].'</field>';
$R[]='		<field name="address_city">'.$a['geo']['name_ru'].'</field>';
if($a['co_street']) $R[]='		<field name="address_street">'.$a['co_street'].'</field>';
if($a['co_house']) $R[]='		<field name="address_house">'.$a['co_house'].'</field>';
if($a['road']) {
	$R[]='		<field name="shosse">'.$a['road']['name_ru'].'</field>';
	$R[]='		<field name="distance_mkad">'.$a['co_distance'].'</field>';
}
if($a['lat']) $R[]='		<field name="geo_lat">'.$a['lat'].'</field>';
if($a['lng']) $R[]='		<field name="geo_lng">'.$a['lng'].'</field>';
$R[]='		<field name="web">'.$a['link'].'</field>';

$R[]='		<field name="'.$squareField.'">'.$a['co_area'].'</field>';
$R[]='		<field name="'.$landField.'">'.$co_place_type[$a['co_place_type']].'</field>';
if($params->height_roof) $R[]='		<field name="house-ceiling-height">'.$params->height_roof.'</field>';

$R[]='		<field name="email">'.$a['agent']['u_email'].'</field>';
$R[]='		<field name="phone">'.$a['agent']['u_phone_work'].'</field>';
$R[]='		<field name="contact">'.$a['agent']['u_surname'].' '.$a['agent']['u_name'].'</field>';
$R[]='	</custom-fields>';
$R[]='</store-ad>';
//Dump($R); exit();
return $R;
}


?>


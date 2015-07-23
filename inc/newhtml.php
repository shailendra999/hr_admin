<div class="current">
      <form name="empolyee_profile" id="empolyee_profile" action="rohit.php" method="post" enctype="multipart/form-data" onSubmit="return valid_empoylee(this);">
        <table width="100%" cellpadding="2" cellspacing="2" border="0" align="center" class="border" style="padding-top:10px;">
          <tr>
            <td width="100%" colspan="2" align="center"><table cellpadding="0" cellspacing="0" border="0" align="center" class="loginbg">
                <tr>
                  <td  class="text_1">Select Employee Type</td>
                  <td><input type="radio" name="empType" id="empStaff" value="1"     />
                    <label for="empStaff">Staff</label>
                    <input type="radio" name="empType" id="empWorker" value="2"  />
                    <label for="empWorker">Worker</label></td>
                  <td width="" class="text_1" style="padding-left:15px;">Empolyee Code<span class="red">*</span></td>
                  <td width=""><!--<input type="text" name="emp_login" id="emp_login" readonly="readonly" style="width:150px; height:20px;" value="">-->
                    
                    <input type="text" name="emp_login" id="emp_login" style="width:150px; height:20px;" value=""  onBlur="check_login_id(this.value);"></td>
                  <td width="30%"><div style="font-size:14px;" id="check_login"></div></td>
                  <!--
                                        <td width="13%" class="text_1" style="padding-left:15px;">Empolyee Code<span class="red">*</span></td>
                                      <td width="25%"><!--<input type="text" name="emp_login" id="emp_login" readonly="readonly" style="width:150px; height:20px;" value="">
                                      <input type="text" name="emp_login" id="emp_login" style="width:150px; height:20px;" value="" onBlur="check_login_id(this.value);"></td>
                                      <td><div id="check_login"></div></td>--> 
                  <!--<td style="padding-top:5px;"><div id="check_login"></div></td>--> 
                  <!--<td class="text_1" style="padding-top:0px;">Password<span class="red">*</span></td>
                                        <td><input type="password" name="password" id="password" style="width:150px; height:20px;"/></td>
                                        <td class="text_1" style="padding-top:0px;">Retype Password<span class="red">*</span></td>
                                        <td><input type="password" name="re_password" id="re_password" style="width:150px; height:20px;"/></td>--> 
                </tr>
              </table></td>
          </tr>
          <tr>
            <td>hello this is personal_detaill_test.php
<table><tr>
<td valign="top"><table width="100%" cellpadding="2" cellspacing="2" class="border" border="0">
                  <tr>
                    <td class="text_1">First Name<span class="red">*</span></td>
                    <td align="left" style="padding-top:5px;"><input type="text" name="first_name" id="first_name" style="width:150px; height:20px;" value="<?=$first_name?>"/></td>
                  </tr>
                  <tr>
                    <td class="text_1">Last Name<span class="red">*</span></td>
                    <td align="left" style="padding-top:5px;"><input type="text" name="last_name" id="last_name" style="width:150px; height:20px;" value="<?=$last_name?>"/></td>
                  </tr>
                  <tr>
                    <td class="text_1" valign="top">Address</td>
                    <td align="left" style="padding-top:5px;"><textarea name="address" id="address"  rows="4" cols="32" style="height:105px;"><?=$address?></textarea></td>
                  </tr>
                  <tr>
                    <td class="text_1">Country</td>
                    <td align="left">                      <select name="country" id="country" onChange="get_frm1('get_state.php',this.value,'div_add_state','state');">
                        <option value="">-select country-</option>
                                                <option value="1" >
                        Afghanistan                        </option>
                                                <option value="2" >
                        Albania                        </option>
                                                <option value="3" >
                        Algeria                        </option>
                                                <option value="4" >
                        American Samoa                        </option>
                                                <option value="5" >
                        Andorra                        </option>
                                                <option value="6" >
                        Angola                        </option>
                                                <option value="7" >
                        Anguilla                        </option>
                                                <option value="8" >
                        Antarctica                        </option>
                                                <option value="9" >
                        Antigua and Barbuda                        </option>
                                                <option value="10" >
                        Argentina                        </option>
                                                <option value="11" >
                        Armenia                        </option>
                                                <option value="12" >
                        Aruba                        </option>
                                                <option value="13" >
                        Australia                        </option>
                                                <option value="14" >
                        Austria                        </option>
                                                <option value="15" >
                        Azerbaijan                        </option>
                                                <option value="16" >
                        Bahamas                        </option>
                                                <option value="17" >
                        Bahrain                        </option>
                                                <option value="18" >
                        Bangladesh                        </option>
                                                <option value="19" >
                        Barbados                        </option>
                                                <option value="20" >
                        Belarus                        </option>
                                                <option value="21" >
                        Belgium                        </option>
                                                <option value="22" >
                        Belize                        </option>
                                                <option value="23" >
                        Benin                        </option>
                                                <option value="24" >
                        Bermuda                        </option>
                                                <option value="25" >
                        Bhutan                        </option>
                                                <option value="26" >
                        Bolivia                        </option>
                                                <option value="27" >
                        Bosnia and Herzegowina                        </option>
                                                <option value="28" >
                        Botswana                        </option>
                                                <option value="29" >
                        Bouvet Island                        </option>
                                                <option value="30" >
                        Brazil                        </option>
                                                <option value="31" >
                        British Indian Ocean Territory                        </option>
                                                <option value="32" >
                        Brunei Darussalam                        </option>
                                                <option value="33" >
                        Bulgaria                        </option>
                                                <option value="34" >
                        Burkina Faso                        </option>
                                                <option value="35" >
                        Burundi                        </option>
                                                <option value="36" >
                        Cambodia                        </option>
                                                <option value="37" >
                        Cameroon                        </option>
                                                <option value="38" >
                        Canada                        </option>
                                                <option value="39" >
                        Cape Verde                        </option>
                                                <option value="40" >
                        Cayman Islands                        </option>
                                                <option value="41" >
                        Central African Republic                        </option>
                                                <option value="42" >
                        Chad                        </option>
                                                <option value="43" >
                        Chile                        </option>
                                                <option value="44" >
                        China                        </option>
                                                <option value="45" >
                        Christmas Island                        </option>
                                                <option value="46" >
                        Cocos (Keeling) Islands                        </option>
                                                <option value="47" >
                        Colombia                        </option>
                                                <option value="48" >
                        Comoros                        </option>
                                                <option value="49" >
                        Congo                        </option>
                                                <option value="50" >
                        Cook Islands                        </option>
                                                <option value="51" >
                        Costa Rica                        </option>
                                                <option value="52" >
                        Cote D'Ivoire                        </option>
                                                <option value="53" >
                        Croatia                        </option>
                                                <option value="54" >
                        Cuba                        </option>
                                                <option value="55" >
                        Cyprus                        </option>
                                                <option value="56" >
                        Czech Republic                        </option>
                                                <option value="57" >
                        Denmark                        </option>
                                                <option value="58" >
                        Djibouti                        </option>
                                                <option value="59" >
                        Dominica                        </option>
                                                <option value="60" >
                        Dominican Republic                        </option>
                                                <option value="61" >
                        East Timor                        </option>
                                                <option value="62" >
                        Ecuador                        </option>
                                                <option value="63" >
                        Egypt                        </option>
                                                <option value="64" >
                        El Salvador                        </option>
                                                <option value="65" >
                        Equatorial Guinea                        </option>
                                                <option value="66" >
                        Eritrea                        </option>
                                                <option value="67" >
                        Estonia                        </option>
                                                <option value="68" >
                        Ethiopia                        </option>
                                                <option value="69" >
                        Falkland Islands (Malvinas)                        </option>
                                                <option value="70" >
                        Faroe Islands                        </option>
                                                <option value="71" >
                        Fiji                        </option>
                                                <option value="72" >
                        Finland                        </option>
                                                <option value="73" >
                        France                        </option>
                                                <option value="74" >
                        France, Metropolitan                        </option>
                                                <option value="75" >
                        French Guiana                        </option>
                                                <option value="76" >
                        French Polynesia                        </option>
                                                <option value="77" >
                        French Southern Territories                        </option>
                                                <option value="78" >
                        Gabon                        </option>
                                                <option value="79" >
                        Gambia                        </option>
                                                <option value="80" >
                        Georgia                        </option>
                                                <option value="81" >
                        Germany                        </option>
                                                <option value="82" >
                        Ghana                        </option>
                                                <option value="83" >
                        Gibraltar                        </option>
                                                <option value="84" >
                        Greece                        </option>
                                                <option value="85" >
                        Greenland                        </option>
                                                <option value="86" >
                        Grenada                        </option>
                                                <option value="87" >
                        Guadeloupe                        </option>
                                                <option value="88" >
                        Guam                        </option>
                                                <option value="89" >
                        Guatemala                        </option>
                                                <option value="90" >
                        Guinea                        </option>
                                                <option value="91" >
                        Guinea-bissau                        </option>
                                                <option value="92" >
                        Guyana                        </option>
                                                <option value="93" >
                        Haiti                        </option>
                                                <option value="94" >
                        Heard and Mc Donald Islands                        </option>
                                                <option value="95" >
                        Honduras                        </option>
                                                <option value="96" >
                        Hong Kong                        </option>
                                                <option value="97" >
                        Hungary                        </option>
                                                <option value="98" >
                        Iceland                        </option>
                                                <option value="99" >
                        India                        </option>
                                                <option value="100" >
                        Indonesia                        </option>
                                                <option value="101" >
                        Iran (Islamic Republic of)                        </option>
                                                <option value="102" >
                        Iraq                        </option>
                                                <option value="103" >
                        Ireland                        </option>
                                                <option value="104" >
                        Israel                        </option>
                                                <option value="105" >
                        Italy                        </option>
                                                <option value="106" >
                        Jamaica                        </option>
                                                <option value="107" >
                        Japan                        </option>
                                                <option value="108" >
                        Jordan                        </option>
                                                <option value="109" >
                        Kazakhstan                        </option>
                                                <option value="110" >
                        Kenya                        </option>
                                                <option value="111" >
                        Kiribati                        </option>
                                                <option value="112" >
                        Korea, Democratic People's Republic of                        </option>
                                                <option value="113" >
                        Korea, Republic of                        </option>
                                                <option value="114" >
                        Kuwait                        </option>
                                                <option value="115" >
                        Kyrgyzstan                        </option>
                                                <option value="116" >
                        Lao People's Democratic Republic                        </option>
                                                <option value="117" >
                        Latvia                        </option>
                                                <option value="118" >
                        Lebanon                        </option>
                                                <option value="119" >
                        Lesotho                        </option>
                                                <option value="120" >
                        Liberia                        </option>
                                                <option value="121" >
                        Libyan Arab Jamahiriya                        </option>
                                                <option value="122" >
                        Liechtenstein                        </option>
                                                <option value="123" >
                        Lithuania                        </option>
                                                <option value="124" >
                        Luxembourg                        </option>
                                                <option value="125" >
                        Macau                        </option>
                                                <option value="126" >
                        Macedonia, The Former Yugoslav Republic of                        </option>
                                                <option value="127" >
                        Madagascar                        </option>
                                                <option value="128" >
                        Malawi                        </option>
                                                <option value="129" >
                        Malaysia                        </option>
                                                <option value="130" >
                        Maldives                        </option>
                                                <option value="131" >
                        Mali                        </option>
                                                <option value="132" >
                        Malta                        </option>
                                                <option value="133" >
                        Marshall Islands                        </option>
                                                <option value="134" >
                        Martinique                        </option>
                                                <option value="135" >
                        Mauritania                        </option>
                                                <option value="136" >
                        Mauritius                        </option>
                                                <option value="137" >
                        Mayotte                        </option>
                                                <option value="138" >
                        Mexico                        </option>
                                                <option value="139" >
                        Micronesia, Federated States of                        </option>
                                                <option value="140" >
                        Moldova, Republic of                        </option>
                                                <option value="141" >
                        Monaco                        </option>
                                                <option value="142" >
                        Mongolia                        </option>
                                                <option value="143" >
                        Montserrat                        </option>
                                                <option value="144" >
                        Morocco                        </option>
                                                <option value="145" >
                        Mozambique                        </option>
                                                <option value="146" >
                        Myanmar                        </option>
                                                <option value="147" >
                        Namibia                        </option>
                                                <option value="148" >
                        Nauru                        </option>
                                                <option value="149" >
                        Nepal                        </option>
                                                <option value="150" >
                        Netherlands                        </option>
                                                <option value="151" >
                        Netherlands Antilles                        </option>
                                                <option value="152" >
                        New Caledonia                        </option>
                                                <option value="153" >
                        New Zealand                        </option>
                                                <option value="154" >
                        Nicaragua                        </option>
                                                <option value="155" >
                        Niger                        </option>
                                                <option value="156" >
                        Nigeria                        </option>
                                                <option value="157" >
                        Niue                        </option>
                                                <option value="158" >
                        Norfolk Island                        </option>
                                                <option value="159" >
                        Northern Mariana Islands                        </option>
                                                <option value="160" >
                        Norway                        </option>
                                                <option value="161" >
                        Oman                        </option>
                                                <option value="162" >
                        Pakistan                        </option>
                                                <option value="163" >
                        Palau                        </option>
                                                <option value="164" >
                        Panama                        </option>
                                                <option value="165" >
                        Papua New Guinea                        </option>
                                                <option value="166" >
                        Paraguay                        </option>
                                                <option value="167" >
                        Peru                        </option>
                                                <option value="168" >
                        Philippines                        </option>
                                                <option value="169" >
                        Pitcairn                        </option>
                                                <option value="170" >
                        Poland                        </option>
                                                <option value="171" >
                        Portugal                        </option>
                                                <option value="172" >
                        Puerto Rico                        </option>
                                                <option value="173" >
                        Qatar                        </option>
                                                <option value="174" >
                        Reunion                        </option>
                                                <option value="175" >
                        Romania                        </option>
                                                <option value="176" >
                        Russian Federation                        </option>
                                                <option value="177" >
                        Rwanda                        </option>
                                                <option value="178" >
                        Saint Kitts and Nevis                        </option>
                                                <option value="179" >
                        Saint Lucia                        </option>
                                                <option value="180" >
                        Saint Vincent and the Grenadines                        </option>
                                                <option value="181" >
                        Samoa                        </option>
                                                <option value="182" >
                        San Marino                        </option>
                                                <option value="183" >
                        Sao Tome and Principe                        </option>
                                                <option value="184" >
                        Saudi Arabia                        </option>
                                                <option value="185" >
                        Senegal                        </option>
                                                <option value="186" >
                        Seychelles                        </option>
                                                <option value="187" >
                        Sierra Leone                        </option>
                                                <option value="188" >
                        Singapore                        </option>
                                                <option value="189" >
                        Slovakia (Slovak Republic)                        </option>
                                                <option value="190" >
                        Slovenia                        </option>
                                                <option value="191" >
                        Solomon Islands                        </option>
                                                <option value="192" >
                        Somalia                        </option>
                                                <option value="193" >
                        South Africa                        </option>
                                                <option value="194" >
                        South Georgia and the South Sandwich Islands                        </option>
                                                <option value="195" >
                        Spain                        </option>
                                                <option value="196" >
                        Sri Lanka                        </option>
                                                <option value="197" >
                        St. Helena                        </option>
                                                <option value="198" >
                        St. Pierre and Miquelon                        </option>
                                                <option value="199" >
                        Sudan                        </option>
                                                <option value="200" >
                        Suriname                        </option>
                                                <option value="201" >
                        Svalbard and Jan Mayen Islands                        </option>
                                                <option value="202" >
                        Swaziland                        </option>
                                                <option value="203" >
                        Sweden                        </option>
                                                <option value="204" >
                        Switzerland                        </option>
                                                <option value="205" >
                        Syrian Arab Republic                        </option>
                                                <option value="206" >
                        Taiwan                        </option>
                                                <option value="207" >
                        Tajikistan                        </option>
                                                <option value="208" >
                        Tanzania, United Republic of                        </option>
                                                <option value="209" >
                        Thailand                        </option>
                                                <option value="210" >
                        Togo                        </option>
                                                <option value="211" >
                        Tokelau                        </option>
                                                <option value="212" >
                        Tonga                        </option>
                                                <option value="213" >
                        Trinidad and Tobago                        </option>
                                                <option value="214" >
                        Tunisia                        </option>
                                                <option value="215" >
                        Turkey                        </option>
                                                <option value="216" >
                        Turkmenistan                        </option>
                                                <option value="217" >
                        Turks and Caicos Islands                        </option>
                                                <option value="218" >
                        Tuvalu                        </option>
                                                <option value="219" >
                        Uganda                        </option>
                                                <option value="220" >
                        Ukraine                        </option>
                                                <option value="221" >
                        United Arab Emirates                        </option>
                                                <option value="222" >
                        United Kingdom                        </option>
                                                <option value="223" >
                        United States                        </option>
                                                <option value="224" >
                        United States Minor Outlying Islands                        </option>
                                                <option value="225" >
                        Uruguay                        </option>
                                                <option value="226" >
                        Uzbekistan                        </option>
                                                <option value="227" >
                        Vanuatu                        </option>
                                                <option value="228" >
                        Vatican City State (Holy See)                        </option>
                                                <option value="229" >
                        Venezuela                        </option>
                                                <option value="230" >
                        Viet Nam                        </option>
                                                <option value="231" >
                        Virgin Islands (British)                        </option>
                                                <option value="232" >
                        Virgin Islands (U.S.)                        </option>
                                                <option value="233" >
                        Wallis and Futuna Islands                        </option>
                                                <option value="234" >
                        Western Sahara                        </option>
                                                <option value="235" >
                        Yemen                        </option>
                                                <option value="236" >
                        Yugoslavia                        </option>
                                                <option value="237" >
                        Zaire                        </option>
                                                <option value="238" >
                        Zambia                        </option>
                                                <option value="239" >
                        Zimbabwe                        </option>
                                              </select></td>
                  </tr>
                  <tr>
                    <td class="text_1">State</td>
                    <td align="left"><div id="div_add_state">
                                                <select name="state" id="state" onChange="get_frm('get_city_reg.php',this.value,'div_city','city_select');">
                          <option value="">--select state--</option>
                                                    <option value="32" >
                          Andaman and Nicobar Islands                          </option>
                                                    <option value="5" >
                          Andhra Pradesh                          </option>
                                                    <option value="27" >
                          Arunachal Pradesh                          </option>
                                                    <option value="14" >
                          Assam                          </option>
                                                    <option value="3" >
                          Bihar                          </option>
                                                    <option value="29" >
                          Chandigarh                          </option>
                                                    <option value="17" >
                          Chhattisgarh                          </option>
                                                    <option value="33" >
                          Dadra and Nagar Haveli                          </option>
                                                    <option value="34" >
                          Daman and Diu                          </option>
                                                    <option value="18" >
                          Delhi                          </option>
                                                    <option value="26" >
                          Goa                          </option>
                                                    <option value="10" >
                          Gujarat                          </option>
                                                    <option value="16" >
                          Haryana                          </option>
                                                    <option value="21" >
                          Himachal Pradesh                          </option>
                                                    <option value="19" >
                          Jammu and Kashmir                          </option>
                                                    <option value="13" >
                          Jharkhand                          </option>
                                                    <option value="9" >
                          Karnataka                          </option>
                                                    <option value="12" >
                          Kerala                          </option>
                                                    <option value="35" >
                          Lakshadweep                          </option>
                                                    <option value="7" >
                          Madhya Pradesh                          </option>
                                                    <option value="2" >
                          Maharashtra                          </option>
                                                    <option value="23" >
                          Manipur                          </option>
                                                    <option value="24" >
                          Meghalaya                           </option>
                                                    <option value="30" >
                          Mizoram                          </option>
                                                    <option value="25" >
                          Nagaland                          </option>
                                                    <option value="11" >
                          Orissa                          </option>
                                                    <option value="28" >
                          Pondicherry                           </option>
                                                    <option value="15" >
                          Punjab                          </option>
                                                    <option value="8" >
                          Rajasthan                          </option>
                                                    <option value="31" >
                          Sikkim                          </option>
                                                    <option value="6" >
                          Tamil Nadu                          </option>
                                                    <option value="22" >
                          Tripura                          </option>
                                                    <option value="1" >
                          Uttar Pradesh                          </option>
                                                    <option value="20" >
                          Uttarakhand                          </option>
                                                    <option value="4" >
                          West Bengal                          </option>
                                                  </select>
                                              </div></td>
                  </tr>
                  <tr>
                    <td class="text_1">City</td>
                    <td align="left"><div id="div_city">
                                                <select name="city_select" id="city_select">
                          <option value="">--select city--</option>
                                                    <option value="553" >
                           Deoghar                          </option>
                                                    <option value="327" >
                          Adilabad                          </option>
                                                    <option value="325" >
                          Agra                          </option>
                                                    <option value="10" >
                          Ahmedabad                          </option>
                                                    <option value="291" >
                          Ahmednagar                          </option>
                                                    <option value="30" >
                          Aizawl                          </option>
                                                    <option value="445" >
                          Ajmer                          </option>
                                                    <option value="292" >
                          Akola                          </option>
                                                    <option value="231" >
                          Alappuzha                          </option>
                                                    <option value="326" >
                          Aligarh                          </option>
                                                    <option value="36" >
                          Alirajpur                          </option>
                                                    <option value="349" >
                          Allahabad                          </option>
                                                    <option value="189" >
                          Almora                          </option>
                                                    <option value="446" >
                          Alwar                          </option>
                                                    <option value="16" >
                          Ambala                          </option>
                                                    <option value="350" >
                          Ambedkar Nagar                          </option>
                                                    <option value="293" >
                          Amravati                          </option>
                                                    <option value="497" >
                          Amreli                          </option>
                                                    <option value="15" >
                          Amritsar                          </option>
                                                    <option value="498" >
                          Anand                          </option>
                                                    <option value="328" >
                          Anantapur                          </option>
                                                    <option value="201" >
                          Anantnag                          </option>
                                                    <option value="131" >
                          Andaman                          </option>
                                                    <option value="521" >
                          Angul                          </option>
                                                    <option value="53" >
                          Anuppur                          </option>
                                                    <option value="255" >
                          Araria                          </option>
                                                    <option value="70" >
                          Ashoknagar                          </option>
                                                    <option value="351" >
                          Auraiya                          </option>
                                                    <option value="294" >
                          Aurangabad                          </option>
                                                    <option value="256" >
                          Aurangabad                          </option>
                                                    <option value="352" >
                          Azamgarh                          </option>
                                                    <option value="476" >
                          Bagalkot                          </option>
                                                    <option value="190" >
                          Bageshwar                          </option>
                                                    <option value="353" >
                          Bagpat                          </option>
                                                    <option value="354" >
                          Bahraich                          </option>
                                                    <option value="37" >
                          Balaghat                          </option>
                                                    <option value="522" >
                          Balangir                          </option>
                                                    <option value="523" >
                          Baleswar                          </option>
                                                    <option value="355" >
                          Ballia                          </option>
                                                    <option value="356" >
                          Balrampur                          </option>
                                                    <option value="499" >
                          Banaskantha                          </option>
                                                    <option value="357" >
                          Banda                          </option>
                                                    <option value="9" >
                          Bangalore                          </option>
                                                    <option value="477" >
                          Bangalore Rural                          </option>
                                                    <option value="257" >
                          Banka                          </option>
                                                    <option value="85" >
                          Bankura                          </option>
                                                    <option value="447" >
                          Banswara                          </option>
                                                    <option value="358" >
                          Barabanki                          </option>
                                                    <option value="202" >
                          Baramulla                          </option>
                                                    <option value="448" >
                          Baran                          </option>
                                                    <option value="90" >
                          Bardhaman                          </option>
                                                    <option value="359" >
                          Bareilly                          </option>
                                                    <option value="524" >
                          Bargarh                          </option>
                                                    <option value="449" >
                          Barmer                          </option>
                                                    <option value="572" >
                          Barnala                          </option>
                                                    <option value="14" >
                          Barpeta                          </option>
                                                    <option value="54" >
                          Barwani                          </option>
                                                    <option value="214" >
                          Bastar                          </option>
                                                    <option value="360" >
                          Basti                          </option>
                                                    <option value="573" >
                          Bathinda                          </option>
                                                    <option value="295" >
                          Beed                          </option>
                                                    <option value="258" >
                          Begusarai                          </option>
                                                    <option value="478" >
                          Belgaum                          </option>
                                                    <option value="479" >
                          Bellary                          </option>
                                                    <option value="71" >
                          Betul                          </option>
                                                    <option value="525" >
                          Bhadrak                          </option>
                                                    <option value="259" >
                          Bhagalpur                          </option>
                                                    <option value="296" >
                          Bhandara                          </option>
                                                    <option value="450" >
                          Bharatpur                          </option>
                                                    <option value="500" >
                          Bharuch                          </option>
                                                    <option value="501" >
                          Bhavnagar                          </option>
                                                    <option value="451" >
                          Bhilwara                          </option>
                                                    <option value="38" >
                          Bhind                          </option>
                                                    <option value="591" >
                          Bhiwani                          </option>
                                                    <option value="260" >
                          Bhojpur                          </option>
                                                    <option value="55" >
                          Bhopal                          </option>
                                                    <option value="11" >
                          Bhubaneswar                          </option>
                                                    <option value="480" >
                          Bidar                          </option>
                                                    <option value="481" >
                          Bijapur                          </option>
                                                    <option value="215" >
                          Bijapur                          </option>
                                                    <option value="361" >
                          Bijnor                          </option>
                                                    <option value="452" >
                          Bikaner                          </option>
                                                    <option value="216" >
                          Bilaspur                          </option>
                                                    <option value="96" >
                          Birbhum                          </option>
                                                    <option value="551" >
                          Bokaro                          </option>
                                                    <option value="102" >
                          Bongaigaon                          </option>
                                                    <option value="526" >
                          Boudh                          </option>
                                                    <option value="362" >
                          Budaun                          </option>
                                                    <option value="203" >
                          Budgam                          </option>
                                                    <option value="363" >
                          Bulandshahr                          </option>
                                                    <option value="297" >
                          Buldhana                          </option>
                                                    <option value="453" >
                          Bundi                          </option>
                                                    <option value="72" >
                          Burhanpur                          </option>
                                                    <option value="261" >
                          Buxar                          </option>
                                                    <option value="103" >
                          Cachar                          </option>
                                                    <option value="178" >
                          Chamba                          </option>
                                                    <option value="191" >
                          Chamoli                          </option>
                                                    <option value="192" >
                          Champawat                          </option>
                                                    <option value="164" >
                          Champhai                          </option>
                                                    <option value="610" >
                          Chamrajnagar                          </option>
                                                    <option value="364" >
                          Chandauli                          </option>
                                                    <option value="153" >
                          Chandel                          </option>
                                                    <option value="29" >
                          Chandigarh                          </option>
                                                    <option value="298" >
                          Chandrapur                          </option>
                                                    <option value="133" >
                          Changlang                          </option>
                                                    <option value="552" >
                          Chatra                          </option>
                                                    <option value="8" >
                          Chennai                          </option>
                                                    <option value="39" >
                          Chhatarpur                          </option>
                                                    <option value="56" >
                          Chhindwara                          </option>
                                                    <option value="482" >
                          Chickmagalur                          </option>
                                                    <option value="483" >
                          Chikballapur                          </option>
                                                    <option value="484" >
                          Chitradurga                          </option>
                                                    <option value="365" >
                          Chitrakoot                          </option>
                                                    <option value="329" >
                          Chittoor                          </option>
                                                    <option value="454" >
                          Chittorgarh                          </option>
                                                    <option value="154" >
                          Churachandpur                          </option>
                                                    <option value="455" >
                          Churu                          </option>
                                                    <option value="367" >
                          Coimbatore                          </option>
                                                    <option value="86" >
                          Cooch Behar                          </option>
                                                    <option value="368" >
                          Cuddalore                          </option>
                                                    <option value="330" >
                          Cuddapah                          </option>
                                                    <option value="527" >
                          Cuttack                          </option>
                                                    <option value="502" >
                          Dahod                          </option>
                                                    <option value="485" >
                          Dakshina Kannada                          </option>
                                                    <option value="21" >
                          Dalhousie                          </option>
                                                    <option value="35" >
                          Daman                          </option>
                                                    <option value="73" >
                          Damoh                          </option>
                                                    <option value="503" >
                          Dang                          </option>
                                                    <option value="262" >
                          Darbhanga                          </option>
                                                    <option value="91" >
                          Darjeeling                          </option>
                                                    <option value="104" >
                          Darrang                          </option>
                                                    <option value="40" >
                          Datia                          </option>
                                                    <option value="456" >
                          Dausa                          </option>
                                                    <option value="611" >
                          Davangere                          </option>
                                                    <option value="193" >
                          Dehradun                          </option>
                                                    <option value="18" >
                          Delhi                          </option>
                                                    <option value="528" >
                          Deogarh                          </option>
                                                    <option value="366" >
                          Deoria                          </option>
                                                    <option value="57" >
                          Dewas                          </option>
                                                    <option value="217" >
                          Dhamtari                          </option>
                                                    <option value="554" >
                          Dhanbad                          </option>
                                                    <option value="74" >
                          Dhar                          </option>
                                                    <option value="371" >
                          Dharmapuri                          </option>
                                                    <option value="612" >
                          Dharwad                          </option>
                                                    <option value="105" >
                          Dhemaji                          </option>
                                                    <option value="529" >
                          Dhenkanal                          </option>
                                                    <option value="457" >
                          Dholpur                          </option>
                                                    <option value="106" >
                          Dhubri                          </option>
                                                    <option value="299" >
                          Dhule                          </option>
                                                    <option value="134" >
                          Dibang Valley                          </option>
                                                    <option value="107" >
                          Dibrugarh                          </option>
                                                    <option value="124" >
                          Dimapur                          </option>
                                                    <option value="372" >
                          Dindigul                          </option>
                                                    <option value="41" >
                          Dindori                          </option>
                                                    <option value="177" >
                          Diu                          </option>
                                                    <option value="204" >
                          Doda                          </option>
                                                    <option value="555" >
                          Dumka                          </option>
                                                    <option value="458" >
                          Dungarpur                          </option>
                                                    <option value="17" >
                          Durg                          </option>
                                                    <option value="263" >
                          East Champaran                          </option>
                                                    <option value="244" >
                          East Delhi                          </option>
                                                    <option value="331" >
                          East Godavari                          </option>
                                                    <option value="135" >
                          East Kameng                          </option>
                                                    <option value="171" >
                          East Khasi Hills                          </option>
                                                    <option value="97" >
                          East Medinipur                          </option>
                                                    <option value="136" >
                          East Siang                          </option>
                                                    <option value="252" >
                          East Sikkim                          </option>
                                                    <option value="556" >
                          East Singhbhum                          </option>
                                                    <option value="232" >
                          Ernakulam                          </option>
                                                    <option value="373" >
                          Erode                          </option>
                                                    <option value="369" >
                          Etah                          </option>
                                                    <option value="370" >
                          Etawah                          </option>
                                                    <option value="375" >
                          Faizabad                          </option>
                                                    <option value="592" >
                          Faridabad                          </option>
                                                    <option value="574" >
                          Faridkot                          </option>
                                                    <option value="376" >
                          Farrukhabad                          </option>
                                                    <option value="593" >
                          Fatehabad                          </option>
                                                    <option value="575" >
                          Fatehgarh Sahib                          </option>
                                                    <option value="379" >
                          Fatehpur                          </option>
                                                    <option value="576" >
                          Ferozepur                          </option>
                                                    <option value="380" >
                          Firozabad                          </option>
                                                    <option value="613" >
                          Gadag                          </option>
                                                    <option value="300" >
                          Gadchiroli                          </option>
                                                    <option value="530" >
                          Gajapati                          </option>
                                                    <option value="504" >
                          Gandhinagar                          </option>
                                                    <option value="31" >
                          Gangtok                          </option>
                                                    <option value="531" >
                          Ganjam                          </option>
                                                    <option value="557" >
                          Garhwa                          </option>
                                                    <option value="383" >
                          Gautam Buddha Nagar                          </option>
                                                    <option value="264" >
                          Gaya                          </option>
                                                    <option value="384" >
                          Ghaziabad                          </option>
                                                    <option value="389" >
                          Ghazipur                          </option>
                                                    <option value="558" >
                          Giridih                          </option>
                                                    <option value="108" >
                          Goalpara                          </option>
                                                    <option value="559" >
                          Godda                          </option>
                                                    <option value="109" >
                          Golaghat                          </option>
                                                    <option value="390" >
                          Gonda                          </option>
                                                    <option value="301" >
                          Gondia                          </option>
                                                    <option value="265" >
                          Gopalganj                          </option>
                                                    <option value="393" >
                          Gorakhpur                          </option>
                                                    <option value="486" >
                          Gulbarga                          </option>
                                                    <option value="560" >
                          Gumla                          </option>
                                                    <option value="58" >
                          Guna                          </option>
                                                    <option value="332" >
                          Guntur                          </option>
                                                    <option value="577" >
                          Gurdaspur                          </option>
                                                    <option value="594" >
                          Gurgaon                          </option>
                                                    <option value="75" >
                          Gwalior                          </option>
                                                    <option value="110" >
                          Hailakandi                          </option>
                                                    <option value="179" >
                          Hamirpur                          </option>
                                                    <option value="394" >
                          Hamirpur                          </option>
                                                    <option value="459" >
                          Hanumangarh                          </option>
                                                    <option value="42" >
                          Harda                          </option>
                                                    <option value="397" >
                          Hardoi                          </option>
                                                    <option value="20" >
                          Haridwar                          </option>
                                                    <option value="487" >
                          Hassan                          </option>
                                                    <option value="398" >
                          Hathras                          </option>
                                                    <option value="488" >
                          Haveri                          </option>
                                                    <option value="561" >
                          Hazaribag                          </option>
                                                    <option value="302" >
                          Hingoli                          </option>
                                                    <option value="595" >
                          Hisar                          </option>
                                                    <option value="87" >
                          Hooghly                          </option>
                                                    <option value="59" >
                          Hoshangabad                          </option>
                                                    <option value="578" >
                          Hoshiarpur                          </option>
                                                    <option value="92" >
                          Howrah                          </option>
                                                    <option value="7" >
                          Hyderabad                          </option>
                                                    <option value="233" >
                          Idukki                          </option>
                                                    <option value="23" >
                          Imphal                          </option>
                                                    <option value="155" >
                          Imphal East                          </option>
                                                    <option value="156" >
                          Imphal West                          </option>
                                                    <option value="2" >
                          Indore                          </option>
                                                    <option value="27" >
                          Itanagar                          </option>
                                                    <option value="43" >
                          Jabalpur                          </option>
                                                    <option value="532" >
                          Jagatsinghapur                          </option>
                                                    <option value="172" >
                          Jaintia Hills                          </option>
                                                    <option value="4" >
                          Jaipur                          </option>
                                                    <option value="460" >
                          Jaisalmer                          </option>
                                                    <option value="533" >
                          Jajpur                          </option>
                                                    <option value="579" >
                          Jalandhar                          </option>
                                                    <option value="403" >
                          Jalaun                          </option>
                                                    <option value="303" >
                          Jalgaon                          </option>
                                                    <option value="304" >
                          Jalna                          </option>
                                                    <option value="461" >
                          Jalore                          </option>
                                                    <option value="98" >
                          Jalpaiguri                          </option>
                                                    <option value="205" >
                          Jammu                          </option>
                                                    <option value="505" >
                          Jamnagar                          </option>
                                                    <option value="562" >
                          Jamtara                          </option>
                                                    <option value="266" >
                          Jamui                          </option>
                                                    <option value="218" >
                          Janjgir-Champa                          </option>
                                                    <option value="219" >
                          Jashpur                          </option>
                                                    <option value="404" >
                          Jaunpur                          </option>
                                                    <option value="267" >
                          Jehanabad                          </option>
                                                    <option value="60" >
                          Jhabua                          </option>
                                                    <option value="596" >
                          Jhajjar                          </option>
                                                    <option value="462" >
                          Jhalawar                          </option>
                                                    <option value="407" >
                          Jhansi                          </option>
                                                    <option value="534" >
                          Jharsuguda                          </option>
                                                    <option value="463" >
                          Jhunjhunu                          </option>
                                                    <option value="597" >
                          Jind                          </option>
                                                    <option value="464" >
                          Jodhpur                          </option>
                                                    <option value="111" >
                          Jorhat                          </option>
                                                    <option value="506" >
                          Junagadh                          </option>
                                                    <option value="408" >
                          Jyotiba Phule Nagar                          </option>
                                                    <option value="220" >
                          Kabirdham-Kawardha                          </option>
                                                    <option value="268" >
                          Kaimur (Bhabua)                          </option>
                                                    <option value="598" >
                          Kaithal                          </option>
                                                    <option value="535" >
                          Kalahandi                          </option>
                                                    <option value="112" >
                          Kamrup                          </option>
                                                    <option value="374" >
                          Kanchipuram                          </option>
                                                    <option value="536" >
                          Kandhamal                          </option>
                                                    <option value="180" >
                          Kangra                          </option>
                                                    <option value="413" >
                          Kannauj                          </option>
                                                    <option value="234" >
                          Kannur                          </option>
                                                    <option value="414" >
                          Kanpur Dehat                          </option>
                                                    <option value="416" >
                          Kanpur Nagar                          </option>
                                                    <option value="377" >
                          Kanyakumari                          </option>
                                                    <option value="580" >
                          Kapurthala                          </option>
                                                    <option value="150" >
                          Karaikal                          </option>
                                                    <option value="465" >
                          Karauli                          </option>
                                                    <option value="113" >
                          Karbi Anglong                          </option>
                                                    <option value="206" >
                          Kargil                          </option>
                                                    <option value="114" >
                          Karimganj                          </option>
                                                    <option value="333" >
                          Karimnagar                          </option>
                                                    <option value="599" >
                          Karnal                          </option>
                                                    <option value="378" >
                          Karur                          </option>
                                                    <option value="235" >
                          Kasargod                          </option>
                                                    <option value="207" >
                          Kathua                          </option>
                                                    <option value="269" >
                          Katihar                          </option>
                                                    <option value="76" >
                          Katni                          </option>
                                                    <option value="417" >
                          Kaushambi                          </option>
                                                    <option value="537" >
                          Kendrapara                          </option>
                                                    <option value="538" >
                          Kendujhar                          </option>
                                                    <option value="270" >
                          Khagaria                          </option>
                                                    <option value="334" >
                          Khammam                          </option>
                                                    <option value="44" >
                          Khandwa                          </option>
                                                    <option value="61" >
                          Khargone                          </option>
                                                    <option value="507" >
                          Kheda                          </option>
                                                    <option value="418" >
                          Kheri                          </option>
                                                    <option value="539" >
                          Khordha                          </option>
                                                    <option value="181" >
                          Kinnaur                          </option>
                                                    <option value="271" >
                          Kishanganj                          </option>
                                                    <option value="489" >
                          Kodagu                          </option>
                                                    <option value="563" >
                          Koderma                          </option>
                                                    <option value="25" >
                          Kohima                          </option>
                                                    <option value="115" >
                          Kokrajhar                          </option>
                                                    <option value="490" >
                          Kolar                          </option>
                                                    <option value="165" >
                          Kolasib                          </option>
                                                    <option value="305" >
                          Kolhapur                          </option>
                                                    <option value="236" >
                          Kollam                          </option>
                                                    <option value="491" >
                          Koppal                          </option>
                                                    <option value="540" >
                          Koraput                          </option>
                                                    <option value="221" >
                          Korba                          </option>
                                                    <option value="222" >
                          Korea                          </option>
                                                    <option value="466" >
                          Kota                          </option>
                                                    <option value="237" >
                          Kottayam                          </option>
                                                    <option value="238" >
                          Kozhikode                          </option>
                                                    <option value="335" >
                          Krishna                          </option>
                                                    <option value="381" >
                          Krishnagiri                          </option>
                                                    <option value="182" >
                          Kullu                          </option>
                                                    <option value="208" >
                          Kupwara                          </option>
                                                    <option value="336" >
                          Kurnool                          </option>
                                                    <option value="600" >
                          Kurukshetra                          </option>
                                                    <option value="137" >
                          Kurung Kumey                          </option>
                                                    <option value="419" >
                          Kushinagar                          </option>
                                                    <option value="508" >
                          Kutch                          </option>
                                                    <option value="183" >
                          Lahaul & Spiti                          </option>
                                                    <option value="116" >
                          Lakhimpur                          </option>
                                                    <option value="272" >
                          Lakhisarai                          </option>
                                                    <option value="34" >
                          Lakshadweep                          </option>
                                                    <option value="420" >
                          Lalitpur                          </option>
                                                    <option value="564" >
                          Latehar                          </option>
                                                    <option value="306" >
                          Latur                          </option>
                                                    <option value="166" >
                          Lawngtlai                          </option>
                                                    <option value="209" >
                          Leh                          </option>
                                                    <option value="565" >
                          Lohardaga                          </option>
                                                    <option value="138" >
                          Lohit                          </option>
                                                    <option value="139" >
                          Lower Dibang Valley                          </option>
                                                    <option value="140" >
                          Lower Subansiri                          </option>
                                                    <option value="5" >
                          Lucknow                          </option>
                                                    <option value="581" >
                          Ludhiana                          </option>
                                                    <option value="167" >
                          Lunglei                          </option>
                                                    <option value="273" >
                          Madhepura                          </option>
                                                    <option value="274" >
                          Madhubani                          </option>
                                                    <option value="382" >
                          Madurai                          </option>
                                                    <option value="337" >
                          Mahabubnagar                          </option>
                                                    <option value="421" >
                          Maharajganj                          </option>
                                                    <option value="223" >
                          Mahasamund                          </option>
                                                    <option value="151" >
                          Mahe                          </option>
                                                    <option value="601" >
                          Mahendragarh                          </option>
                                                    <option value="422" >
                          Mahoba                          </option>
                                                    <option value="423" >
                          Mainpuri                          </option>
                                                    <option value="239" >
                          Malappuram                          </option>
                                                    <option value="1" >
                          Malda                          </option>
                                                    <option value="541" >
                          Malkangiri                          </option>
                                                    <option value="168" >
                          Mamit                          </option>
                                                    <option value="184" >
                          Mandi                          </option>
                                                    <option value="77" >
                          Mandla                          </option>
                                                    <option value="45" >
                          Mandsaur                          </option>
                                                    <option value="614" >
                          Mandya                          </option>
                                                    <option value="582" >
                          Mansa                          </option>
                                                    <option value="117" >
                          Marigaon                          </option>
                                                    <option value="424" >
                          Mathura                          </option>
                                                    <option value="425" >
                          Mau                          </option>
                                                    <option value="542" >
                          Mayurbhanj                          </option>
                                                    <option value="338" >
                          Medak                          </option>
                                                    <option value="426" >
                          Meerut                          </option>
                                                    <option value="509" >
                          Mehsana                          </option>
                                                    <option value="602" >
                          Mewat                          </option>
                                                    <option value="427" >
                          Mirzapur                          </option>
                                                    <option value="583" >
                          Moga                          </option>
                                                    <option value="125" >
                          Mokokchung                          </option>
                                                    <option value="126" >
                          Mon                          </option>
                                                    <option value="428" >
                          Moradabad                          </option>
                                                    <option value="62" >
                          Morena                          </option>
                                                    <option value="584" >
                          Muktsar                          </option>
                                                    <option value="3" >
                          Mumbai                          </option>
                                                    <option value="307" >
                          Mumbai City                          </option>
                                                    <option value="275" >
                          Munger                          </option>
                                                    <option value="93" >
                          Murshidabad                          </option>
                                                    <option value="429" >
                          Muzaffarnagar                          </option>
                                                    <option value="276" >
                          Muzaffarpur                          </option>
                                                    <option value="493" >
                          Mysore                          </option>
                                                    <option value="543" >
                          Nabarangapur                          </option>
                                                    <option value="99" >
                          Nadia                          </option>
                                                    <option value="118" >
                          Nagaon                          </option>
                                                    <option value="385" >
                          Nagapattinam                          </option>
                                                    <option value="467" >
                          Nagaur                          </option>
                                                    <option value="308" >
                          Nagpur                          </option>
                                                    <option value="194" >
                          Nainital                          </option>
                                                    <option value="277" >
                          Nalanda                          </option>
                                                    <option value="119" >
                          Nalbari                          </option>
                                                    <option value="339" >
                          Nalgonda                          </option>
                                                    <option value="386" >
                          Namakkal                          </option>
                                                    <option value="309" >
                          Nanded                          </option>
                                                    <option value="310" >
                          Nandurbar                          </option>
                                                    <option value="224" >
                          Narayanpur                          </option>
                                                    <option value="510" >
                          Narmada                          </option>
                                                    <option value="78" >
                          Narsinghpur                          </option>
                                                    <option value="311" >
                          Nashik                          </option>
                                                    <option value="511" >
                          Navsari                          </option>
                                                    <option value="278" >
                          Nawada                          </option>
                                                    <option value="585" >
                          Nawanshahr                          </option>
                                                    <option value="544" >
                          Nayagarh                          </option>
                                                    <option value="46" >
                          Neemuch                          </option>
                                                    <option value="340" >
                          Nellore                          </option>
                                                    <option value="245" >
                          New Delhi                          </option>
                                                    <option value="132" >
                          Nicobar                          </option>
                                                    <option value="387" >
                          Nilgiris                          </option>
                                                    <option value="341" >
                          Nizamabad                          </option>
                                                    <option value="225" >
                          Norh Bastar-Kanker                          </option>
                                                    <option value="88" >
                          North 24 Parganas                          </option>
                                                    <option value="120" >
                          North Cachar Hills                          </option>
                                                    <option value="246" >
                          North Delhi                          </option>
                                                    <option value="94" >
                          North Dinajpur                          </option>
                                                    <option value="247" >
                          North East Delhi                          </option>
                                                    <option value="148" >
                          North Goa                          </option>
                                                    <option value="253" >
                          North Sikkim                          </option>
                                                    <option value="161" >
                          North Tripura                          </option>
                                                    <option value="248" >
                          North West Delhi                          </option>
                                                    <option value="545" >
                          Nuapada                          </option>
                                                    <option value="312" >
                          Osmanabad                          </option>
                                                    <option value="566" >
                          Pakur                          </option>
                                                    <option value="240" >
                          Palakkad                          </option>
                                                    <option value="567" >
                          Palamu                          </option>
                                                    <option value="468" >
                          Pali                          </option>
                                                    <option value="603" >
                          Panchkula                          </option>
                                                    <option value="512" >
                          Panchmahals                          </option>
                                                    <option value="604" >
                          Panipat                          </option>
                                                    <option value="26" >
                          Panjim                          </option>
                                                    <option value="63" >
                          Panna                          </option>
                                                    <option value="141" >
                          Papum Pare                          </option>
                                                    <option value="313" >
                          Parbhani                          </option>
                                                    <option value="513" >
                          Patan                          </option>
                                                    <option value="241" >
                          Pathanamthitta                          </option>
                                                    <option value="586" >
                          Patiala                          </option>
                                                    <option value="6" >
                          Patna                          </option>
                                                    <option value="195" >
                          Pauri Garhwal                          </option>
                                                    <option value="388" >
                          Perambalur                          </option>
                                                    <option value="127" >
                          Phek                          </option>
                                                    <option value="22" >
                          Pilak                          </option>
                                                    <option value="430" >
                          Pilibhit                          </option>
                                                    <option value="196" >
                          Pithoragarh                          </option>
                                                    <option value="28" >
                          Pondicherry                          </option>
                                                    <option value="210" >
                          Poonch                          </option>
                                                    <option value="514" >
                          Porbandar                          </option>
                                                    <option value="32" >
                          Port Blair                          </option>
                                                    <option value="342" >
                          Prakasam                          </option>
                                                    <option value="431" >
                          Pratapgarh                          </option>
                                                    <option value="391" >
                          Pudukkottai                          </option>
                                                    <option value="211" >
                          Pulwama                          </option>
                                                    <option value="314" >
                          Pune                          </option>
                                                    <option value="546" >
                          Puri                          </option>
                                                    <option value="279" >
                          Purnia                          </option>
                                                    <option value="100" >
                          Purulia                          </option>
                                                    <option value="432" >
                          RaeBareli                          </option>
                                                    <option value="494" >
                          Raichur                          </option>
                                                    <option value="315" >
                          Raigad                          </option>
                                                    <option value="226" >
                          Raigarh                          </option>
                                                    <option value="227" >
                          Raipur                          </option>
                                                    <option value="79" >
                          Raisen                          </option>
                                                    <option value="212" >
                          Rajauri                          </option>
                                                    <option value="47" >
                          Rajgarh                          </option>
                                                    <option value="515" >
                          Rajkot                          </option>
                                                    <option value="228" >
                          Rajnandgaon                          </option>
                                                    <option value="469" >
                          Rajsamand                          </option>
                                                    <option value="392" >
                          Ramanathapuram                          </option>
                                                    <option value="433" >
                          Rampur                          </option>
                                                    <option value="13" >
                          Ranchi                          </option>
                                                    <option value="343" >
                          Rangareddy                          </option>
                                                    <option value="64" >
                          Ratlam                          </option>
                                                    <option value="316" >
                          Ratnagiri                          </option>
                                                    <option value="547" >
                          Rayagada                          </option>
                                                    <option value="80" >
                          Rewa                          </option>
                                                    <option value="605" >
                          Rewari                          </option>
                                                    <option value="173" >
                          Ri Bhoi                          </option>
                                                    <option value="606" >
                          Rohtak                          </option>
                                                    <option value="280" >
                          Rohtas                          </option>
                                                    <option value="197" >
                          Rudraprayag                          </option>
                                                    <option value="587" >
                          Rupnagar                          </option>
                                                    <option value="516" >
                          Sabarkantha                          </option>
                                                    <option value="48" >
                          Sagar                          </option>
                                                    <option value="434" >
                          Saharanpur                          </option>
                                                    <option value="281" >
                          Saharsa                          </option>
                                                    <option value="568" >
                          Sahibganj                          </option>
                                                    <option value="169" >
                          Saiha                          </option>
                                                    <option value="395" >
                          Salem                          </option>
                                                    <option value="282" >
                          Samastipur                          </option>
                                                    <option value="548" >
                          Sambalpur                          </option>
                                                    <option value="317" >
                          Sangli                          </option>
                                                    <option value="588" >
                          Sangrur                          </option>
                                                    <option value="435" >
                          Sant Kabir Nagar                          </option>
                                                    <option value="436" >
                          Sant Ravidas Nagar                          </option>
                                                    <option value="283" >
                          Saran                          </option>
                                                    <option value="589" >
                          SAS Nagar                          </option>
                                                    <option value="318" >
                          Satara                          </option>
                                                    <option value="65" >
                          Satna                          </option>
                                                    <option value="470" >
                          Sawai Madhopur                          </option>
                                                    <option value="81" >
                          Sehore                          </option>
                                                    <option value="157" >
                          Senapati                          </option>
                                                    <option value="49" >
                          Seoni                          </option>
                                                    <option value="569" >
                          Seraikela                          </option>
                                                    <option value="170" >
                          Serchhip                          </option>
                                                    <option value="82" >
                          Shahdol                          </option>
                                                    <option value="437" >
                          Shahjahanpur                          </option>
                                                    <option value="50" >
                          Shajapur                          </option>
                                                    <option value="284" >
                          Sheikhpura                          </option>
                                                    <option value="285" >
                          Sheohar                          </option>
                                                    <option value="67" >
                          Sheopur                          </option>
                                                    <option value="24" >
                          Shillong                          </option>
                                                    <option value="185" >
                          Shimla                          </option>
                                                    <option value="495" >
                          Shimoga                          </option>
                                                    <option value="83" >
                          Shivpuri                          </option>
                                                    <option value="438" >
                          Shravasti                          </option>
                                                    <option value="439" >
                          Siddharthnagar                          </option>
                                                    <option value="51" >
                          Sidhi                          </option>
                                                    <option value="471" >
                          Sikar                          </option>
                                                    <option value="33" >
                          Silvassa                          </option>
                                                    <option value="570" >
                          Simdega                          </option>
                                                    <option value="319" >
                          Sindhudurg                          </option>
                                                    <option value="66" >
                          Singrauli                          </option>
                                                    <option value="186" >
                          Sirmaur                          </option>
                                                    <option value="472" >
                          Sirohi                          </option>
                                                    <option value="607" >
                          Sirsa                          </option>
                                                    <option value="286" >
                          Sitamarhi                          </option>
                                                    <option value="440" >
                          Sitapur                          </option>
                                                    <option value="396" >
                          Sivaganga                          </option>
                                                    <option value="121" >
                          Sivasagar                          </option>
                                                    <option value="287" >
                          Siwan                          </option>
                                                    <option value="187" >
                          Solan                          </option>
                                                    <option value="320" >
                          Solapur                          </option>
                                                    <option value="441" >
                          Sonbhadra                          </option>
                                                    <option value="608" >
                          Sonipat                          </option>
                                                    <option value="122" >
                          Sonitpur                          </option>
                                                    <option value="89" >
                          South 24 Parganas                          </option>
                                                    <option value="230" >
                          South Bastar-Dantewada  Surguja                          </option>
                                                    <option value="249" >
                          South Delhi                          </option>
                                                    <option value="95" >
                          South Dinajpur                          </option>
                                                    <option value="174" >
                          South Garo Hills                          </option>
                                                    <option value="149" >
                          South Goa                          </option>
                                                    <option value="162" >
                          South Tripura                          </option>
                                                    <option value="250" >
                          South West Delhi                          </option>
                                                    <option value="473" >
                          Sri Ganganagar                          </option>
                                                    <option value="344" >
                          Srikakulam                          </option>
                                                    <option value="19" >
                          Srinagar                          </option>
                                                    <option value="549" >
                          Subarnapur                          </option>
                                                    <option value="442" >
                          Sultanpur                          </option>
                                                    <option value="550" >
                          Sundergarh                          </option>
                                                    <option value="288" >
                          Supaul                          </option>
                                                    <option value="517" >
                          Surat                          </option>
                                                    <option value="518" >
                          Surendranagar                          </option>
                                                    <option value="229" >
                          Surguja                          </option>
                                                    <option value="158" >
                          Tamenglong                          </option>
                                                    <option value="590" >
                          Tarn Taran                          </option>
                                                    <option value="142" >
                          Tawang                          </option>
                                                    <option value="198" >
                          Tehri Garhwal                          </option>
                                                    <option value="321" >
                          Thane                          </option>
                                                    <option value="399" >
                          Thanjavur                          </option>
                                                    <option value="400" >
                          Theni                          </option>
                                                    <option value="12" >
                          Thiruvananthapuram                          </option>
                                                    <option value="401" >
                          Thoothukudi                          </option>
                                                    <option value="159" >
                          Thoubal                          </option>
                                                    <option value="242" >
                          Thrissur                          </option>
                                                    <option value="68" >
                          Tikamgarh                          </option>
                                                    <option value="123" >
                          Tinsukia                          </option>
                                                    <option value="143" >
                          Tirap                          </option>
                                                    <option value="402" >
                          Tiruchirappalli                          </option>
                                                    <option value="405" >
                          Tirunelveli                          </option>
                                                    <option value="406" >
                          Tiruvallur                          </option>
                                                    <option value="409" >
                          Tiruvannamalai                          </option>
                                                    <option value="410" >
                          Tiruvarur                          </option>
                                                    <option value="474" >
                          Tonk                          </option>
                                                    <option value="128" >
                          Tuensang                          </option>
                                                    <option value="615" >
                          Tumkur                          </option>
                                                    <option value="475" >
                          Udaipur                          </option>
                                                    <option value="199" >
                          Udham Singh Nagar                          </option>
                                                    <option value="213" >
                          Udhampur                          </option>
                                                    <option value="616" >
                          Udupi                          </option>
                                                    <option value="84" >
                          Ujjain                          </option>
                                                    <option value="160" >
                          Ukhrul                          </option>
                                                    <option value="52" >
                          Umaria                          </option>
                                                    <option value="188" >
                          Una                          </option>
                                                    <option value="443" >
                          Unnao                          </option>
                                                    <option value="144" >
                          Upper Siang                          </option>
                                                    <option value="145" >
                          Upper Subansiri                          </option>
                                                    <option value="496" >
                          Uttara Kannada                          </option>
                                                    <option value="200" >
                          Uttarkashi                          </option>
                                                    <option value="519" >
                          Vadodara                          </option>
                                                    <option value="289" >
                          Vaishali                          </option>
                                                    <option value="520" >
                          Valsad                          </option>
                                                    <option value="444" >
                          Varanasi                          </option>
                                                    <option value="411" >
                          Vellore                          </option>
                                                    <option value="69" >
                          Vidisha                          </option>
                                                    <option value="412" >
                          Viluppuram                          </option>
                                                    <option value="415" >
                          Virudhunagar                          </option>
                                                    <option value="345" >
                          Visakhapatnam                          </option>
                                                    <option value="346" >
                          Vizianagaram                          </option>
                                                    <option value="347" >
                          Warangal                          </option>
                                                    <option value="322" >
                          Wardha                          </option>
                                                    <option value="323" >
                          Washim                          </option>
                                                    <option value="243" >
                          Wayanad                          </option>
                                                    <option value="290" >
                          West Champaran                          </option>
                                                    <option value="251" >
                          West Delhi                          </option>
                                                    <option value="175" >
                          West Garo Hills                          </option>
                                                    <option value="348" >
                          West Godavari                          </option>
                                                    <option value="146" >
                          West Kameng                          </option>
                                                    <option value="176" >
                          West Khasi Hills                          </option>
                                                    <option value="101" >
                          West Medinipur                          </option>
                                                    <option value="147" >
                          West Siang                          </option>
                                                    <option value="254" >
                          West Sikkim                          </option>
                                                    <option value="571" >
                          West Singhbhum                          </option>
                                                    <option value="163" >
                          West Tripura                          </option>
                                                    <option value="129" >
                          Wokha                          </option>
                                                    <option value="609" >
                          Yamunanagar                          </option>
                                                    <option value="152" >
                          Yanam                          </option>
                                                    <option value="324" >
                          Yavatmal                          </option>
                                                    <option value="130" >
                          Zunheboto                          </option>
                                                  </select>
                                              </div></td>
                  </tr>
                  <tr>
                    <td class="text_1">Pin Code</td>
                    <td align="left"><input type="text" name="pin_code" id="pin_code" style="width:150px; height:20px;" value="<?=$pincode?>/></td>
                  </tr>
                  <tr>
                    <td class="text_1">Date Of Birth</td>
                    <td align="left"><input type="text" name="dob" id="dob" style="width:150px; height:20px;" value="<?=getDatetime($dob)?>"/>
                      
                  </tr>
                </table></td>
                <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0">
                  <tr>
                    <td width="43%" class="text_1">Gender</td>
                    <td width="57%" align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="gender" name="gender" value="Male" checked="checked"/>
                      Male
                      <input type="radio" id="gender" name="gender" value="Female"/>
                      Female </td>
                  </tr>
                  <tr>
                    <td class="text_1">Phone</td>
                    <td align="left"><input type="text" name="phone_no" id="phone_no" style="width:150px; height:20px;" value="<?=$phone_no?>"/></td>
                  </tr>
                  <tr>
                    <td class="text_1">Email Id</td>
                    <td align="left"><input type="text" name="email_id" id="email_id" style="width:150px; height:20px;" value="<?=$email_id?>"/></td>
                  </tr>
                  <tr>
                    <td class="text_1">Marital Status</td>
                    <td align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="hide" name="marital" value="yes" onClick="marriage_date(this)" />
                      Married
                      <input type="radio" id="show" name="marital" value="no" onClick="marriage_date(this)" checked="checked"/>
                      Single </td>
                  </tr>
                  <tr id="ss">
                    <td class="text_1">if Married then date of Marriage</td>
                    <td align="left"><input type="text" name="marr_date" id="marr_date" disabled="disabled" style="width:150px; height:20px;" value=""/>
                      <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_profile.marr_date);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                  </tr>
                  <tr>
                    <td class="text_1">Blood Group</td>
                    <td align="left"><select name="blood_group" id="blood_group">
                        <option value="">---Select---</option>
                        <option value="O-" <? if($blood_group=='O-'){echo 'selected="selected"';}?> >O-</option>
                        <option value="O+" <? if($blood_group=='O+'){echo 'selected="selected"';}?>>O+</option>
                        <option value="A-" <? if($blood_group=='A-'){echo 'selected="selected"';}?>>A-</option>
                        <option value="A+" <? if($blood_group=='A+'){echo 'selected="selected"';}?>>A+</option>
                        <option value="B-" <? if($blood_group=='B-'){echo 'selected="selected"';}?>>B-</option>
                        <option value="B+" <? if($blood_group=='B+'){echo 'selected="selected"';}?>>B+</option>
                        <option value="AB-" <? if($blood_group=='AB-'){echo 'selected="selected"';}?>>AB-</option>
                        <option value="AB+"  <? if($blood_group=='AB+'){echo 'selected="selected"';}?>>AB+</option>
                      </select>
                      </select></td>
                  </tr>
                  <tr>
                    <td class="text_1">Religion</td>
                    <td align="left"><input type="text" name="religion" id="religion" style="width:150px; height:20px;" value="<?=$religion?>"/></td>
                  </tr>
                  <tr>
                    <td class="text_1">Nationality</td>
                    <td align="left"><input type="text" name="nationality" id="nationality" style="width:150px; height:20px;" value="<?=$nationality?>"/>/td>
                  </tr>
                  <tr>
                    <td class="text_1">Reference</td>
                    <td align="left"><input type="text" name="reference" id="reference" style="width:150px; height:20px;" value="<?=$reference?>"/></td>
                  </tr>
                  <tr>
                    <td class="text_1">Employee picture</td>
                    <td align="left"><input type="file" name="emp_pic" id="emp_pic" style="width:150px; height:20px;"/></td>
                                                          </tr>
                </table></td></tr></table></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:center;"><input type="submit"  value="Submit" name="Submit_emp" id="Submit_emp"/>
                          <input name="no_refresh" type="hidden" id="no_refresh" value="15664799135416e45dbfdff" />
            </td>
          
            </tr>
          
        </table>
      </form>
    </div>
    <!-----------------------PERSONAL DETAILL ENDS HERE---------------------> 
    
    <!-----------------------Family Detail Starts here------------------->
    
    hello this is family_detail_test.php
 <div class="simpleTabsContent">
      
      <form name="empolyee_family" id="empolyee_family" action="rohit.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
        <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0" style="padding-top:10px">
          <tr>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td class="text_1" width="35%">Father Name(Mr.)</td>
                  <td align="left" width="65%"><input type="text" name="father_name" id="father_name" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">Depended</td>
                  <td align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="Dependant_member1" name="Dependant_member1" value="Yes" checked="checked"/>
                    Yes
                    <input type="radio" id="Dependant_member1" name="Dependant_member1" value="No" />
                    No </td>
                </tr>
                <tr>
                  <td class="text_1">Mother Name(Mrs.) </td>
                  <td align="left"><input type="text" name="mother_name" id="mother_name" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">Depended</td>
                  <td align="left" class="text_1" style="padding-left:0px;"><input type="radio" id="Dependant_member2" name="Dependant_member2" value="Yes"checked="checked"/>
                    Yes
                    <input type="radio" id="Dependant_member2" name="Dependant_member2" value="No"/>
                    No </td>
                </tr>
                                              </table></td>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td class="text_1" width="35%">Date of Birth</td>
                  <td align="left" width="65%"><input type="text" name="father_dob" id="father_dob" style="width:150px; height:20px;" value=""/>
                    <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_family.father_dob);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                </tr>
                <tr>
                  <td class="text_1">Occupation</td>
                  <td align="left"><input type="text" name="father_occupation" id="father_occupation" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">Date of Birth </td>
                  <td align="left"><input type="text" name="mother_dob" id="mother_dob" style="width:150px; height:20px;" value=""/>
                    <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.empolyee_family.mother_dob);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                </tr>
                <tr>
                  <td class="text_1">Occupation</td>
                  <td align="left"><input type="text" name="mother_occupation" id="mother_occupation" style="width:150px; height:20px;" value=""/></td>
                </tr>
                              </table></td>
          </tr>
                        <tr>
                <td style="text-align:center;" colspan="4">
                <input type="submit"  value="Submit" name="emp_family" id="emp_family"/>
                        
          <!-------------------Child Information Ends Here ------------------------------------>
          <tr>
            <td colspan="2" style="text-align:center;"><div id="myDiv1"></div></td>
          </tr>
          <tr>
         
          
            <input name="no_refresh" type="hidden" id="no_refresh" value="5786786525416e45dc5829" />
              </td>
          </tr>
        </table>
      </form>
    </div>
     <script>
function addElements() {
  var ni = document.getElementById('myDiv1');
  var numi = document.getElementById('h_hidden');
  var num = (document.getElementById('h_hidden').value -1)+ 2;
  numi.value = num;
  var newdiv = document.createElement('div');
  var divIdName = 'my'+num+'Div1';
  var myDivName='myDiv1';
  newdiv.setAttribute('id',divIdName);
newdiv.innerHTML = "<table align='center' width='100%' border='0' cellpadding='1' cellspacing='0'><tr><td align='left' style='width:256px;'><input name='child_name[]' type='text' value='' style='width:180px;height:20px;' /></td><td align='left' style='width:251px;'>male<input name='child_gender"+num+"[] 'id='child_gender' type='radio' value='male' />female<input name='child_gender"+num+"[]' id='child_gender' type='radio' value='female' /></td><td align='left' style='width: 253px;'>yes<input name='child_dependent"+num+"[]' id='child_dependent' type='radio' value='yes' />no<input name='child_dependent"+num+"[]' type='radio' value='no' /></td><td align='left' style='width:246px;'><input name='child_dob[]' id='chil_dob' type='text' value='' style='width:150px;height:20px;'/></td><td class='delete' style='padding-right:10px;'><a href=\"javascript:;\" onclick=\"removeElements(\'"+divIdName+"\'\,'"+myDivName+"\')\"><img src='images/delete_icon.jpg' border='0'/></span></a></td></tr></table>";
 ni.appendChild(newdiv);
}
</script> 

              
               
    <!-----------------------Family Detail Ends Here------------------> 
    
    
     <!-----------------------Education Detail Start Here------------------->
    
         hello this is education_detail_test.php<div class="simpleTabsContent">
      <form name="empolyee_eduction" id="empolyee_eduction" action="rohit.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
        <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0"  style="padding-top:10px;">
            <tr>
          
          <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
              <tr>
                <td><label>S.S.C.</label></td>
              </tr>
              <tr>
                <td class="text_1">year of passing</td>
                <td align="left"><input type="text" name="qualification" id="qualification" style="width:150px; height:20px;" value=""/></td>
              </tr>
              <tr>
                <td class="text_1">Board</td>
                <td class="text_2" align="left"><input type="text" name="university" id="university" style="width:150px; height:20px;" value=""/></td>
              </tr>
            </table></td>
          <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
              <tr>
              <tr>
                <td class="text_1"></td>
                <td align="left"></td>
              </tr>
              <tr>
                <td class="text_1">Subject</td>
                <td align="left"><input type="text" readonly="readonly" value="All" style="width:150px; height:20px;" name="duration" id="duration"  /></td>
              </tr>
                </tr>
              
              
                <td class="text_1">Percentage </td>
                <td align="left"><input type="text" name="percentage" id="percentage" style="width:150px; height:20px;" value=""/></td>
              </tr>
              <tr>
                <td class="text_1"></td>
                <td align="left"></td>
              </tr>
              <tr>
                <td class="text_1"></td>
                <td align="left"></td>
              </tr>
                </tr>
              
            </table></td>
            </tr>
          
            <tr>
          
          <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
              <tr>
                <td><label>H.S.C</label></td>
              </tr>
              <tr>
                <td class="text_1">Year of passing</td>
                <td align="left"><input type="text" name="hscyear" id="hscyear" style="width:150px; height:20px;" value=""/></td>
              </tr>
              <tr>
                <td class="text_1">Board</td>
                <td class="text_2" align="left"><input type="text" name="hscboard" id="hscboard" style="width:150px; height:20px;" value=""/></td>
              </tr>
            </table></td>
          <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
              <tr>
              <tr>
                <td class="text_1"></td>
                <td align="left"></td>
              </tr>
              <tr>
                <td class="text_1">Subject</td>
                <td align="left"><select name="hscsubject" id="hscsubject">
                    <option  value="">-select-</option>
                    <option value="PCM" >PCM</option>
                    <option value="PCB" >PCB</option>
                    <option value="COMERCE" >COMERCE</option>
                    <option value="ART" >ART</option>
                  </select></td>
              </tr>
              <tr>
                <td class="text_1">Percentage </td>
                <td align="left"><input type="text" name="hscpercentage" id="hscpercentage" style="width:150px; height:20px;" value=""/></td>
              </tr>
              <tr>
                <td class="text_1"></td>
                <td align="left"></td>
              </tr>
              <tr>
                <td class="text_1"></td>
                <td align="left"></td>
              </tr>
                </tr>
              
            </table></td>
            </tr>
          
          <tr>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td><label>Diploma</label>
                <tr>
                  <td>
                
                <tr>
                  <td class="text_1">Qualification</td>
                  <td align="left"><input type="text" name="diplomaqualification" id="diplomaqualification" style="width:150px; height:20px;" value=""/></td>
                
                <tr>
                  <td class="text_1">Year of passing</td>
                  <td align="left"><input type="text" name="diplomayear" id="diplomayear" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">University </td>
                  <td class="text_2" align="left"><input type="text" name="diplomauniversity" id="diplomauniversity" style="width:150px; height:20px;" value=""/></td>
                </tr>
              </table></td>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1">Course Duration</td>
                  <td align="left"><select name="diplomaduration" id="diplomaduration" >
                      <option  value="" >-select-</option>
                      <option value="1" >1year</option>
                      <option value="2" >2year</option>
                      <option value="3" >3year</option>
                      <option value="4" >4year</option>
                    </select></td>
                </tr>
                <tr>
                  <td class="text_1">Percentage </td>
                  <td align="left"><input type="text" name="diplomapercentage" id="diplomapercentage" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td><label>Graduation</label></td>
                </tr>
                <tr>
                  <td class="text_1">Qualification</td>
                  <td align="left"><input type="text" name="graduationqualification" id="graduationqualification" style="width:150px; height:20px;" value=""/></td>
                </tr>
                
                  <td class="text_1">Year of passing</td>

                  <td align="left"><input type="text" name="graduationpassingyear" id="graduationpassingyear" style="width:150px; height:20px;" value=""/></td>
                <tr>
                  <td class="text_1">University</td>
                  <td class="text_2" align="left"><input type="text" name="graduationuniversity" id="graduationuniversity" style="width:150px; height:20px;" value=""/></td>
                </tr>
              </table></td>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1">Course Duration</td>
                  <td align="left"><select name="grdurationDuration" id="grdurationDuration">
                      <option value="">-select-</option>
                      <option value="1" >1year</option>
                      <option value="2year" >2year</option>
                      <option value="3"  >3year</option>
                      <option value="4" >4year</option>
                      <option value="5" >5year</option>
                    </select>
                </tr>
                <tr>
                  <td class="text_1">Percentage </td>
                  <td align="left"><input type="text" name="graduationpercentage" id="graduationpercentage" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td><label>Post-Graduation</label>
                <tr>
                  <td>
                
                <tr>
                  <td class="text_1">Qualification</td>
                  <td align="left"><input type="text" name="mastergraduationqualification" id="mastergrationqualification" style="width:150px; height:20px;" value=""/></td>
                
                <tr>
                  <td class="text_1">Year of passing</td>
                  <td align="left"><input type="text" name="mastergraduationpassingyear" id="mastergraduationpassingyear" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">University </td>
                  <td class="text_2" align="left"><input type="text" name="mastergraduationuniversity" id="mastergraduationuniversity" style="width:150px; height:20px;" value=""/></td>
                </tr>
              </table></td>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                <tr>
                  <td class="text_1">Course Duration</td>
                  <td align="left"><select name="mastergraduationduration" id="mastergraduationduration">
                      <option  value="">-select-</option>
                      <option value="1" >1year</option>
                      <option value="2" >2year</option>
                      <option value="3" >3year</option>
                      <option value="4" >4year</option>
                    </select>
                </tr>
                <tr>
                  <td class="text_1">Percentage </td>
                  <td align="left"><input type="text" name="mastergraduationpercentage" id="mastergraduationpercentage" style="width:150px; height:20px;" value=""/></td>
                </tr>
                
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
                
                  <td class="text_1"></td>
                  <td align="left"></td>
                </tr>
              </table></td>
          </tr>
          <tr>
          <tr>
            <td colspan="2" style="text-align:center;"><input type="submit"  value="Submit" name="emp_education" id="emp_education"/>
                            <input name="no_refresh" type="hidden" id="no_refresh" value="5046977405416e45de5ee6" /></td>
          </tr>
        </table>
      </form>
    </div>
        
    <!-----------------------Education Detail Ends Here ----------------------------> 
    
    <!-----------------------Official-Profile start here----------------------->
      Hello This is official_profile_test.php <div class="simpleTabsContent">
      <form name="offical_profile" id="offical_profile" action="rohit.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
        <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0" style="padding-top:10px;">
          <tr>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td class="text_1">Date of Joining</td>
                  <td align="left"><input type="text" name="date_joining" id="date_joining" style="width:150px; height:20px;" value="//"/>
                    <a href="javascript:void(0)" onClick="gfPop.fPopCalendar(document.offical_profile.date_joining);" HIDEFOCUS><img name="popcal" align="absbottom" src="./calendar/calbtn.gif" width="34" height="22" border="0" alt=""></a></td>
                </tr>
                <tr>
                  <td class="text_1">Plant</td>
                  <td  align="left">                    <select name="plant_name" id="plant_name" style="width:150px; height:20px;">
                      <option value="">Select</option>
                                            <option value="5" >
                      INDORE                      </option>
                                            <option value="7" >
                      NAGDA                      </option>
                                          </select></td>
                </tr>
                <tr>
                  <td class="text_1">Department</td>
                  <td align="left">                    <select name="department" id="department" style="width:150px; height:20px;" onChange="get_frm('get_department.php',this.value,'div_sub_dept','sub_department');">
                      <option value="">Select</option>
                                            <option value="68" >
                      All                      </option>
                                            <option value="61" >
                      DOC                      </option>
                                            <option value="55" >
                      IT                      </option>
                                          </select></td>
                </tr>
                <tr>
                  <td class="text_1">Sub Department</td>
                  <td align="left"><div id="div_sub_dept">
                                            <select name="sub_department" id="sub_department" style="width:150px; height:20px;" onChange="">
                        <option value="">Select</option>
                                                <option value="74" >
                        ABC                        </option>
                                                <option value="82" >
                        ACCOUNTS                        </option>
                                                <option value="81" >
                        AUTOCONER                        </option>
                                                <option value="107" >
                        B/R.CDG MAINT                        </option>
                                                <option value="104" >
                        BLOW ROOM                        </option>
                                                <option value="83" >
                        CARDING                        </option>
                                                <option value="84" >
                        CIVIL                        </option>
                                                <option value="85" >
                        COMBER                        </option>
                                                <option value="86" >
                        COMMERICAL                        </option>
                                                <option value="87" >
                        DRAWING                        </option>
                                                <option value="88" >
                        EDP                        </option>
                                                <option value="89" >
                        ENGG                        </option>
                                                <option value="78" >
                        FSG                        </option>
                                                <option value="110" >
                        FSG MAINT                        </option>
                                                <option value="90" >
                        GENERAL                        </option>
                                                <option value="91" >
                        KNITTING                        </option>
                                                <option value="106" >
                        Maintnance                        </option>
                                                <option value="100" >
                        MANTAINANCE                        </option>
                                                <option value="92" >
                        PACKING                        </option>
                                                <option value="105" >
                        Personnel                        </option>
                                                <option value="93" >
                        PERSONNEL                        </option>
                                                <option value="101" >
                        PREPRATORY                        </option>
                                                <option value="64" >
                        Producation                         </option>
                                                <option value="94" >
                        PRODUCATION                        </option>
                                                <option value="109" >
                        R/F MAINT                        </option>
                                                <option value="77" >
                        RING FRAME                        </option>
                                                <option value="108" >
                        S/F MAINT                        </option>
                                                <option value="95" >
                        SECURITY                        </option>
                                                <option value="96" >
                        SIMPLEX                        </option>
                                                <option value="73" >
                        Software Eng                        </option>
                                                <option value="97" >
                        SQC                        </option>
                                                <option value="102" >
                        STOR                        </option>
                                                <option value="103" >
                        STORE                        </option>
                                                <option value="72" >
                        Testing                         </option>
                                                <option value="98" >
                        TRANSPORT                        </option>
                                                <option value="99" >
                        WINDING                        </option>
                                              </select>
                    </div></td>
                </tr>
                <tr>
                  <td class="text_1">Reporting Authority name</td>
                  <td align="left"><input type="text" name="authority_name" id="authority_name" style="width:150px; height:20px;" value=""/></td>
                </tr>
              </table></td>
            <td width="50%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">

                <tr>
                  <td class="text_1">Grade</td>
                  <td align="left"><input type="text" name="grade" id="grade" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">PAN No.</td>
                  <td align="left"><div id="div_add_div">
                      <input type="text" name="pan_no" id="pan_no" style="width:150px; height:20px;" value=""/>
                    </div></td>
                </tr>
                <tr>
                  <td class="text_1">Employee Type</td>
                  <td align="left"><select name="emp_type" id="emp_type">
                      <option value="fix_salary"  >Fix Salary</option>
                      <option value="daily_wages" >Daily Wages</option>
                    </select></td>
                </tr>
                <tr>
                  <td class="text_1">Employee Catagory</td>
                  <td align="left"><select  name="emp_category" id="emp_category" onChange="get_frm('get_designation.php',this.value,'designation_div','designation');">
                      <option value="staff" >Staff</option>
                      <option value="worker" >Worker</option>
                    </select></td>
                </tr>
                <tr>
                  <td class="text_1">Designation</td>
                  <td align="left"><div id="designation_div">
                                            <select name="designation" id="designation" style="width:150px; height:20px;">
                        <option value="">Select</option>
                                                <option value="96" >
                        Operator                        </option>
                                                <option value="132" >
                        STORE  BOY                         </option>
                                              </select>
                    </div></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td colspan="2" style="text-align:center;">
            <!-- ************************************Added pf details************************************************  *** -->
              
              
                  <div id="div_show" >
                <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                  <tr>
                    <td colspan="2" class="blackHead">PF Detail</td>
                  </tr>
                  <tr>
                    <td align="left"><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                        <tr>
                          <td class="text_1">PF Number</td>
                          <td><input type="text" name="pf_no" id="pf_no" style="width:180px; height:20px;" value=""/></td>
                        </tr>
                        <tr>
                          <td class="text_1">PF Rate</td>
                          <td><input type="text" name="pf_rate" id="pf_rate" style="width:180px; height:20px;" value=""/></td>
                        </tr>
                      </table></td>
                    <td><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                        <tr>
                          <td class="text_1">PF Nominee</td>
                          <td><input type="text" name="pf_nominee" id="pf_nominee" style="width:180px; height:20px;" value=""/></td>
                        </tr>
                        <tr>
                          <td class="text_1">RelationShip</td>
                          <td><input type="text" name="pf_relationship" id="pf_relationship" style="width:180px; height:20px;" value=""/></td>
                        </tr>
                      </table></td>
                  </tr>
                  <tr>
                    <td colspan="2" class="blackHead">ESIC Detail (Employee State Insurance Corporation)</td>
                  </tr>
                  <tr>
                    <td><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                        <tr>
                          <td class="text_1">ESIC Number</td>
                          <td><input type="text" name="esic_no" id="esic_no" style="width:180px; height:20px;" value=""/></td>
                        </tr>
                        <tr>
                          <td class="text_1">ESIC Rate</td>
                          <td><input type="text" name="esic_rate" id="esic_rate" style="width:180px; height:20px;" value=""/></td>
                        </tr>
                      </table></td>
                    <td><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                        <tr>
                          <td class="text_1">ESIC Nominee</td>
                          <td><input type="text" name="esic_nominee" id="esic_nominee" style="width:180px; height:20px;" value=""/></td>
                        </tr>
                        <tr>
                          <td class="text_1">RelationShip</td>
                          <td><input type="text" name="esic_relationship" id="esic_relationship" style="width:180px; height:20px;" value=""/></td>
                        </tr>
                      </table></td>
                  </tr>
                  <tr>
                    <td align="center" colspan="2">                      <input type="hidden" name="emp_id" id="emp_id" value=""/>
                      <input type="hidden" name="update" id="update" value=""/></td>
                  </tr>
                </table>
              </div>
              </td>
              <!--****************************************End**************************************************--> 
               <!--****************************************Shift_details************************************************-->
              
              <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                <tr>
                  <td colspan="2" class="blackHead">Shift Detail</td>
                </tr>
                <tr>
                  <td align="left"><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                      <tr>
                        <td class="text_1" width="40%">Rotation Type</td>
                        <td align="left" width="60%"><div id="div_rotation_type_edit">
                                                        <div id="div_rotation_type"></div>
                          </div></td>
                        <td class="text_1">
                        <td align="center" valign="middle"><select name="rotation_type" id="rotation_type" style="width:150px; height:20px;">
                            <option  value="Weekly">Weekly</option>
                            <option  value="2 Week">2 Week</option>
                            <option  value="Monthly">Monthly</option>
                          </select>
                          <input name="no_refresh" type="hidden" id="no_refresh" value="716437595416e45deff7b" />
                          <input type="hidden" name="emp_id" id="emp_id" value="" />
                        <td><!--<input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Rotation" title="Edit Rotation" onclick="get_frm('change_rotation_edit.php',document.getElementById('rotation_type').value,'div_rotation_type_change','')" />&nbsp;</td>
 <td>
             <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="edit_div('div_rotation_type_edit','')"></td>
	</tr> --> 
                          
                          <!--  <a href="javascript:;" onclick="get_frm('change_rotation.php','','div_rotation_type_edit','')">Change</a>  --></td>
                      </tr>
                      <tr>
                        <td class="text_1">Shift</td>
                        <td align="left"><div id="div_shift_type_edit">
                                                        <div id="div_shift_type"></div>
                          </div></td>
                        <td class="text_1">
                        <td align="center" valign="middle"><select name="shift_duration" id="shift_duration" style="width:150px; height:20px;">
                            <option   value="A">A</option>
                            <option  value="B">B</option>
                            <option  value="C">C</option>
                            <option  value="G">G</option>
                          </select>
                          <input name="no_refresh" type="hidden" id="no_refresh" value="17082434485416e45df2262" />
                          <input type="hidden" name="emp_id" id="emp_id" value="" />
                        <td><!--   <a href="javascript:;" onclick="get_frm('change_shift.php','','div_shift_type_edit','')">Change</a>  --></td>
                      </tr>
                    </table></td>
                  <td><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                      <tr>
                        <td class="text_1" width="40%">Weekly OFF day</td>
                        <td align="left" width="60%"><div id="div_weekly_off_edit">
                                                        <div id="div_weekly_off"></div>
                          </div></td>
                        <td class="text_1"><!--  <a href="javascript:;" onclick="get_frm('change_weekly.php','','div_weekly_off_edit','')">Change</a>  -->
                          
                          <div id="change_weekly_off">
                            <table width="60%" cellpadding="0" cellspacing="0">
                              <tr>
                                <td align="center" valign="middle"><select name="off_days" id="off_days" style="width:150px; height:20px;">
                                    <option  value="Sunday">Sunday</option>
                                    <option  value="Monday">Monday</option>
                                    <option  value="Tuesday">Tuesday</option>
                                    <option  value="Wednesday">Wednesday</option>
                                    <option  value="Thursday">Thursday</option>
                                    <option  value="Friday">Friday</option>
                                    <option  value="Saturday">Saturday</option>
                                  </select>
                                  <input name="no_refresh" type="hidden" id="no_refresh" value="12977701915416e45e00f44" />
                                  <input type="hidden" name="emp_id" id="emp_id" value="" />
                                <td><!--	<input type="image" src="images/Modify.png" name="image_edit" id="image_edit" alt="Edit Weekly Off" title="Edit Weekly Off" onclick="get_frm('change_weekly_edit.php',document.getElementById('off_days').value,'change_weekly_off','')">&nbsp;
         </td>
         <td>
             <img src="images/Exit.png" alt="Cancel" title="Cancel" onClick="edit_div('div_weekly_off_edit','')">  --></td>
                              </tr>
                            </table>
                          </div></td>
                      </tr>
                      <tr>
                        <td colspan="2">&nbsp;</td>
                      </tr>
                    </table></td>
                </tr>
                <!--    <tr>
    	<td colspan="2" align="center">
        	<input type="image" src="images/btn_submit.png" name="submit_shift" id="submit_shift" value="Submit"/>
            <input type="hidden" name="emp_id" id="emp_id" value=""/>
        </td>
    </tr>-->
              </table>
              
              <!--**************************************end*************************************************************--> 
              <!--*************************************Department Designation***************************************** -->
              
               <!--****************************************end**********************************************************--> 
              <!--********************************Bank detailos******************************************************  -->
              
              <div id="div_insert_bank">
                <table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                  <tr>
                    <td colspan="2" class="blackHead">Bank Detail</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top"><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                        <tr>
                          <td class="text_1" width="60%">Mode of Payment</td>
                          <td align="left" width="40%"><select id="payment_mode" name="payment_mode">
                              <option  selected value="Cash">Cash</option>
                              <option  value="Cheque">Cheque</option>
                              <option  value="Online">Online</option>
                            </select></td>
                        </tr>
                      </table></td>
                    <td><table width="100%" cellpadding="2" cellspacing="2" align="center" border="0" class="border">
                        <tr>
                          <td class="text_1" width="40%">Bank Name</td>
                          <td align="left" width="60%"><input type="text" name="bank_name" value="" id="bank_name" style="width:150px; height:20px;"/></td>
                        </tr>
                        <tr>
                          <td class="text_1" width="40%">Account Number</td>
                          <td align="left" width="60%"><input type="text" name="account_no" value="" id="account_no" style="width:150px; height:20px;"/></td>
                        </tr>
                      </table></td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center"><!--<input type="image" src="images/btn_submit.png" name="submit_pf" id="submit_pf" value="Submit" onclick="post_frm('bank_update.php','1','div_insert_bank',document.getElementById('payment_mode').value,document.getElementById('bank_name').value,document.getElementById('account_no').value,'')"/>--></td>
                  </tr>
                </table>
              </div>
              
              <!--****************************************end**********************************************************-->
              
              <input type="submit"  value="Submit" name="emp_offical" id="emp_offical"/>
                            <input name="no_refresh" type="hidden" id="no_refresh" value="4681529105416e45e1a19e" /></td>
          </tr>
        </table>
      </form>
    </div>
    
    <!-----------------------Official Profile Ends Here-------------------> 
    <!-----------------------Salary_detail start here------------------>
    
     salary_detail_test.php <div class="simpleTabsContent">
      <form name="salary_detail" id="salary_detail" action="employee_detail.php" method="post" enctype="multipart/form-data" onSubmit="return valid_customer(this);">
        <table align="center" width="100%" cellpadding="2" cellspacing="2" class="border" border="0" style="padding-top:10px;">
          <tr>
            <td width="32%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td>Fixed Compensation </td>
                </tr>
                <tr>
                  <td class="text_1">Basic</td>
                  <td align="left"><input type="text" onBlur="sum_salary()" name="basic" id="basic" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">HRA</td>
                  <td align="left"><input type="text" name="hra" id="hra" onBlur="sum_salary()" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <!--<tr>
                                        <td class="text_1">LTA</td>
                                        <td align="left"><input type="text" name="lta" id="lta" style="width:150px; height:20px;" value=""/></td>
                                  </tr>-->
                <tr>
                  <td class="text_1">Conveyance</td>
                  <td align="left"><input type="text" name="convence" onBlur="sum_salary()" id="convence" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <!--<tr>
                                        <td class="text_1">Medical</td>
                                        <td align="left"><input type="text" name="medical" id="medical" style="width:150px; height:20px;" value=""/></td>
                                    </tr>-->
                
                <tr>
                  <td class="text_1">Special Allowance</td>
                  <td align="left"><input type="text" name="side_allowance" id="side_allowance" style="width:150px; height:20px;" onBlur="sum_salary()" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">Phone</td>
                  <td align="left"><input type="text" name="phone_allowance" id="phone_allowance" style="width:150px; height:20px;" onBlur="sum_salary()" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">Others</td>
                  <td align="left"><input type="text" name="others" id="others" style="width:150px; height:20px;" onBlur="sum_salary()" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">Earning</td>
                  <td align="left"><input type="text" readonly="readonly" name="earning" id="earning" style="width:150px; height:20px;" value=""/></td>
                </tr>
              </table></td>
            <td width="36%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td>Employee Contribution</td>
                </tr>
                <!--<tr>
                                        <td class="text_1">Professional Tax</td>
                                        <td align="left"><input type="text" name="p_tax" id="p_tax" style="width:150px; height:20px;" value=""/></td>
                                    </tr>--> 
                <!--<tr>
                                        <td class="text_1">TDS</td>
                                        <td align="left"><input type="text" name="tds" id="tds" style="width:150px; height:20px;" value=""/></td>
                                    </tr>
                                    <tr>
                                        <td class="text_1">Advance</td>
                                        <td align="left"><input type="text" name="advance" id="advance" style="width:150px; height:20px;" value=""/></td>
                                    </tr>
                                     <tr>
                                        <td class="text_1">Loan</td>
                                        <td align="left"><input type="text" name="loan" id="loan" style="width:150px; height:20px;" value=""/></td>
                                    </tr>-->
                <tr>
                  <td class="text_1">PF Deduction </td>
                  <td>Celling
                    <input  type="radio" onClick="sum_salary()"  value="yes" id="cell" name="cell">
                    Nocelling
                    <input type="radio" onClick="sum_salary()" checked id="nocell" value="no" name="cell"></td>
                </tr>
                <tr>
                  <td class="text_1">PF</td>
                  <td align="left"><input readonly="readonly" type="text" name="PF" id="PF" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">ESIC</td>
                  <td align="left"><input type="text" readonly="readonly" name="ESIC" id="ESIC" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">Bonus</td>
                  <td align="left"><input type="text" onBlur="sum_salary()"  name="bonus" id="bonus" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">Deduction </td>
                  <td><input type="text" name="deduction" readonly="readonly" id="deduction" style="width:150px; height:20px;" value=""/></td>
                </tr>
              </table></td>
            <td width="32%" valign="top"><table align="center" width="100%" cellpadding="2" cellspacing="2" class="border">
                <tr>
                  <td>Employer Contribution</td>
                </tr>
                <tr>
                  <td class="text_1">PF</td>
                  <td align="left"><input readonly="readonly" type="text" name="PF1" id="PF1" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">ESIC</td>
                  <td align="left"><input type="text" readonly="readonly" name="ESIC1" id="ESIC1" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">Medical</td>
                  <td align="left"><input type="text" onBlur="sum_salary()" name="medical" id="medical" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">Gratuity</td>
                  <td><input type="text" name="gratuity" onBlur="sum_salary()" id="gratuity" style="width:150px; height:20px;" value=""/></td>
                </tr>
                <tr>
                  <td class="text_1">Deduction </td>
                  <td><input type="text" readonly="readonly" name="deduction1" id="deduction1" style="width:150px; height:20px;" value=""/></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td colspan="4" style="text-align:center;"><input type="submit"  value="Submit" name="emp_salary" id="emp_salary"/>
                            <input name="no_refresh" type="hidden" id="no_refresh" value="19853737065416e45e1c7c9" /></td>
          </tr>
        </table>
      </form>
    </div>   
<!-----------------------Salary Detail Ends Here--------------------------------------------->
    
    
    
    
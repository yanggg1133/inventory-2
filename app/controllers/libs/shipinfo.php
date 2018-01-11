<?php

	class ShipInfo {

		    function stateAbbrev($state) 
			{
				$state = ucwords(strtolower($state));

				switch ($state){
                    case "Alabama":
                        return "AL";
                        break;

                    case "Alaska":
                        return "AK";
                        break;

                    case "Arizona":
                        return "AZ";
                        break;

                    case "Arkansas":
                        return "AR";
                        break;

                    case "California":
                        return "CA";
                        break;

                    case "Colorado":
                        return "CO";
                        break;

                    case "Connecticut":
                        return "CT";
                        break;

                    case "Delaware":
                        return "DE";
                        break;

                    case "Florida":
                        return "FL";
                        break;

                    case "Georgia":
                        return "GA";
                        break;

                    case "Hawaii":
                        return "HI";
                        break;

                    case "Idaho":
                        return "ID";
                        break;

                    case "Illinois":
                        return "IL";
                        break;

                    case "Indiana":
                        return "IN";
                        break;

                    case "Iowa":
                        return "IA";
                        break;

                    case "Kansas":
                        return "KS";
                        break;

                    case "Kentucky":
                        return "KY";
                        break;

                    case "Louisiana":
                        return "LA";
                        break;

                    case "Maine":
                        return "ME";
                        break;

                    case "Maryland":
                        return "MD";
                        break;

                    case "Massachusetts":
                        return "MA";
                        break;

                    case "Michigan":
                        return "MI";
                        break;

                    case "Minnesota":
                        return "MN";
                        break;

                    case "Mississippi":
                        return "MS";
                        break;

                    case "Missouri":
                        return "MO";
                        break;

                    case "Montana":
                        return "MT";
                        break;

                    case "Nebraska":
                        return "NE";
                        break;

                    case "Nevada":
                        return "NV";
                        break;

                    case "New Hampshire":
                        return "NH";
                        break;

                    case "New Jersey":
                        return "NJ";
                        break;

                    case "New Mexico":
                        return "NM";
                        break;

                    case "New York":
                        return "NY";
                        break;

                    case "North Carolina":
                        return "NC";
                        break;

                    case "North Dakota":
                        return "ND";
                        break;

                    case "Ohio":
                        return "OH";
                        break;

                    case "Oklahoma":
                        return "OK";
                        break;

                    case "Oregon":
                        return "OR";
                        break;

                    case "Pennsylvania":
                        return "PA";
                        break;

                    case "Rhode Island":
                        return "RI";
                        break;

                    case "South Carolina":
                        return "SC";
                        break;

                    case "South Dakota":
                        return "SD";
                        break;

                    case "Tennessee":
                        return "TN";
                        break;

                    case "Texas":
                        return "TX";
                        break;

                    case "Utah":
                        return "UT";
                        break;

                    case "Vermont":
                        return "VT";
                        break;

                    case "Virginia":
                        return "VA";
                        break;

                    case "Washington":
                        return "WA";
                        break;

                    case "West Virginia":
                        return "WV";
                        break;

                    case "Wisconsin":
                        return "WI";
                        break;

                    case "Wyoming":
                        return "WY";
                        break;

                    default:
                        return strtoupper($state);
                        break;
				}
			}
		}
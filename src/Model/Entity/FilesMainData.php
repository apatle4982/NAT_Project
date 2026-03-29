<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FilesMainData Entity 
 *
 * @property int $id
 * @property int $company_id
 * @property int $ImportSheetId
 * @property string|null $CenterBranch
 * @property string $LoanNumber
 * @property string|null $LoanAmount
 * @property \Cake\I18n\FrozenTime|null $FileStartDate
 * @property string|null $PartnerID
 * @property string|null $NATFileNumber
 * @property string|null $PartnerFileNumber
 * @property string|null $Grantors
 * @property string|null $GrantorFirstName1
 * @property string $GrantorLastName1
 * @property string|null $GrantorFirstName2
 * @property string $GrantorLastName2
 * @property string|null $GrantorMaritalStatus
 * @property string|null $GrantorCorporationName
 * @property string|null $Grantees
 * @property string|null $GranteeFirstName1
 * @property string $GranteeLastName1
 * @property string|null $GranteeFirstName2
 * @property string $GranteeLastName2
 * @property string|null $marital_status_g2
 * @property string|null $GranteeCorporationName
 * @property string|null $StreetNumber
 * @property string|null $StreetName
 * @property string|null $City
 * @property string|null $County
 * @property string|null $TownshipDivision
 * @property string|null $State
 * @property string $APNParcelNumber
 * @property string|null $LegalDescriptionShortLegal
 * @property string|null $Zip
 * @property string|null $A
 * @property string|null $B
 * @property string|null $C
 * @property string|null $D
 * @property string|null $E
 * @property string|null $F
 * @property string|null $G
 * @property string|null $H
 * @property string|null $I
 * @property string|null $J
 * @property string|null $K
 * @property string|null $L
 * @property string|null $M
 * @property string|null $N
 * @property string|null $O
 * @property string|null $P
 * @property string|null $Q
 * @property string $R
 * @property string $S
 * @property string $T
 * @property string $U
 * @property string $V
 * @property string $W
 * @property string $X
 * @property string $Y
 * @property string $Z
 * @property string|null $TransactionType
 * @property string $DocumentImage
 * @property \Cake\I18n\FrozenTime|null $CheckInDateTime
 * @property int $UserId
 * @property string $FileEndDate
 * @property string $DocumentReceived
 * @property int $FCMId
 * @property string $FedexManual
 * @property string $DateAdded
 * @property string $InternalNotes
 * @property string $PublicNotes
 * @property string|null $ECapable
 * @property string $reseach_status 
 *
 * @property \App\Model\Entity\FilesCheckinData $files_checkin_data
 */
class FilesMainData extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'company_id' => true,
        'ImportSheetId' => true,
        'CenterBranch' => true,
        'LoanNumber' => true,
        'LoanAmount' => true,
        'FileStartDate' => true,
        'PartnerID' => true,
        'NATFileNumber' => true,
        'PartnerFileNumber' => true,
        'Grantors' => true,
        'GrantorFirstName1' => true,
        'GrantorLastName1' => true,
        'GrantorFirstName2' => true,
        'GrantorLastName2' => true,
        'GrantorMaritalStatus' => true,
        'GrantorCorporationName' => true,
        'Grantees' => true,
        'GranteeFirstName1' => true,
        'GranteeLastName1' => true,
		'GranteeFirstName2' => true,
        'GranteeLastName2' => true,
        'marital_status_g2' => true,
        'GranteeCorporationName' => true,		
		'MortgagorGrantors' => true,
        'MortgagorGrantorFirstName1' => true,
        'MortgagorGrantorLastName1' => true,
		'MortgagorGrantorFirstName2' => true,
        'MortgagorGrantorLastName2' => true,
        'MortgagorGrantorMaritalStatus' => true,
        'MortgagorGrantorCorporationName' => true,	
		'MortgageeLenderCompanyName' => true,
        'MortgageeFirstName1' => true,
        'MortgageeLastName1' => true,
		'MortgageeFirstName2' => true,
        'MortgageeLastName2' => true,
        'MortgageeMaritalStatus' => true,
        'StreetNumber' => true,
        'StreetName' => true,
        'City' => true,
        'County' => true,
        'TownshipDivision' => true,
        'State' => true,
        'APNParcelNumber' => true,
		'LegalDescriptionShortLegal' => true,
        'Zip' => true,
        'A' => true,
        'B' => true,
        'C' => true,
        'D' => true,
        'E' => true,
        'F' => true,
        'G' => true,
        'H' => true,
        'I' => true,
        'J' => true,
        'K' => true,
        'L' => true,
        'M' => true,
        'N' => true,
        'O' => true,
        'P' => true,
        'Q' => true,
        'R' => true,
        'S' => true,
        'T' => true,
        'U' => true,
        'V' => true,
        'W' => true,
        'X' => true,
        'Y' => true,
        'Z' => true,
        'TransactionType' => true,
        'DocumentImage' => true,
        'CheckInDateTime' => true,
        'UserId' => true,
        'FileEndDate' => true,
        'DocumentReceived' => true,
        'FCMId' => true,
        'FedexManual' => true,
        'DateAdded' => true,
        'InternalNotes' => true,
        'PublicNotes' => true,
        'ECapable' => true,
        'reseach_status' => true,
        'files_checkin_data' => true, 
    ];
}

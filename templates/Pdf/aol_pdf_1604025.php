<style>
body { font-family: Arial, sans-serif; line-height: 1.5; font-size: 12px; margin: 0; padding: 0;}
h2 { text-decoration: underline; }
strong { font-weight: bold; }
.section { margin-bottom: 20px; }
.title { font-weight: bold; text-align: center; text-decoration: underline; margin: 0; padding: 0; }
table { width: 100%; border-collapse: collapse; margin-top: 10px; }
td, th { border: 1px solid black; padding: 5px; }
.requirements li { margin-bottom: 10px; }
.footer { position: fixed; bottom: 0; left: 0; width: 100%; text-align: left; font-size: 10px; color: #555; padding: 10px; border-top: 1px solid #ccc;}
.page-break { page-break-before: always;}
@page { size: A4; margin: 40mm 20mm 30mm 20mm; }
.section1 {width: 100%;margin-bottom: 15px;}
.section1.row {width: 100%;font-size: 12px;line-height: 1.4; }
.section1 .col {display: inline-block;width: 49%; /* 2 columns */vertical-align: top;margin-bottom: 5px;}
</style>

<div class="container">
    <h2 class="title">LEGAL OPINION REGARDING TITLE TO REAL PROPERTY</h2>
    <p>To Whom It May Concern:</p>
    <p>
        The following legal opinion (the <span class="bold">"Opinion"</span>) regarding the state of record
        title to certain real property has been produced and issued by <span class="bold"><?= h($vendor_data['name']) ?></span>
        (the <span class="bold">"Firm"</span>).
        Specifically, this Opinion is issued solely with respect to the following transaction (the <span class="bold">"Transaction"</span>):
    </p>
    <table>
        <tr>
            <td class="bold"><b>Property Address:</b> <?= h($exam["OfficialPropertyAddress"]) ?></td>
            <td class="bold"><b>Borrower(s):</b> <?= h($fmd_data["MortgagorGrantors"]) ?><br><?= h($fmd_data["StreetNumber"]." ".$fmd_data["StreetName"]." ".$fmd_data["City"]." ".$fmd_data["County"]." ".$fmd_data["State"]." ".$fmd_data["Zip"]) ?></td>
        </tr>
        <tr>
            <td class="bold"><b>Lender:</b> <?= h($fmd_data["MortgageeLenderCompanyName"]) ?><br><?= h($fmd_data["StreetNumber"]." ".$fmd_data["StreetName"]." ".$fmd_data["City"]." ".$fmd_data["County"]." ".$fmd_data["State"]." ".$fmd_data["Zip"]) ?></td>
            <td class="bold"><b>Loan Number:</b> <?= h($fmd_data["LoanNumber"]) ?></td>
        </tr>
        <tr>
            <td class="bold"><b>File Number:</b> <?= h($fmd_data["PartnerFileNumber"]) ?></td>
            <td class="bold"><b>Loan Amount:</b> <?= h($fmd_data["LoanAmount"]) ?></td>
        </tr>
    </table>
    <p>
        The Lender has requested a letter certifying that the loan referenced above
        (the <span class="bold">"Mortgage"</span>) will hold the priority expected (the <span class="bold">"Required Priority"</span>).
        Pursuant to this request, we have examined a public records search of title certified
        to <span class="bold"><?= h($exam["lender_name"]) ?></span>, its successors and/or assigns (the <span class="bold">"Lender"</span>),
        dated <span class="bold"><?= h($fmd_data["FileStartDate"]) ?></span> (the <span class="bold">"Effective Date"</span>), regarding the real property identified
        in the Legal Description attached as Exhibit A and incorporated by reference herein (the <span class="bold">"Property"</span>).
    </p>
    <p>As of the Effective Date, based on the Firms review of the public records of <?= h($fmd_data["County"])." " ?><?= h($fmd_data["State"]) ?> (the <strong>"Public Records"</strong>), and subject to the qualifications, limitations, requirements, and exceptions set forth herein, the Firm finds:</p>

    <h3>I. <strong>Matters of Record</strong></h3>
    <p>Title to the Property is vested as set forth below (<strong>"Title"</strong>) and is subject to the encumbrances and exceptions described herein:</p>
    <ol>
        <li>Title is vested in: <?= h($fmd_data["Grantors"]) ?></li>
        <li>The estate or interest in the Property is: Fee Simple</li>
        <li>Title is vested pursuant to:
        <?php $vestinfos = json_decode($exam["vesting_attributes"]);
        if(count($vestinfos) > 0){
        foreach($vestinfos as $vestinfo){ //echo "<pre>";print_r($vestinfo);echo "</pre>";exit;
        ?><br>
        <?= h("Vesting Deed Type: ".$vestinfo->VestingDeedType.", Vesting Dated: ".$vestinfo->VestingDated.", Vesting Recorded Date: ".$vestinfo->VestingRecordedDate.", Vesting Book Page: ".$vestinfo->VestingBookPage.", Vesting Instrument: ".$vestinfo->VestingInstrument) ?>
        <?php } } ?>
</li>
        <li>The liens and encumbrances of record - see attached <strong>Exhibit B</strong>, incorporated by reference herein.</li>
    </ol>

    <h3>II. <strong>Lien Priority</strong></h3>
    <p>As of the Effective Date, the Firm has found that the lien of the Mortgage (including any assignment thereof) on the Title to the Property (the <strong>"Lien"</strong>):</p>
    <p>i.	is a valid and enforceable lien of title of the Required Priority on a fee simple estate to the Property, and has priority over any other liens and encumbrances found on the Title to the Property, except as otherwise expressly stated herein; or,
ii.	has priority over any environmental protection liens filed in the Public Records, and that there are no state statutes that provide that liens filed in the Public Records after the Effective Date would have priority over the Lien, except for any potential subsequent super liens that could take priority over the Subject Mortgage (NOTE: this exception shall only apply if the Property is located in a state whose statutes provide for such a super lien).
</p>
</div>
<div class="page-break"></div>
<div class="page2">
    <div class="section">
        <h3>III. Marketable Title</h3>
        <p>Title to the Property is marketable, subject to the Mortgage and the Requirements listed below. Title to the Property is vested as set forth above, subject to the encumbrances, limitations, and exceptions noted herein. The holder of Title to the Property enjoys a right of legal access to/from the Property.</p>
    </div>

    <div class="section">
        <h3>IV. Requirements</h3>
        <p>The following requirements must be satisfied, in the Firms sole discretion, for this Opinion to remain valid and enforceable:</p>
        <ol class="requirements" type="I">
            <li>The agreed-upon amount to be paid for the estate or interest to be transferred pursuant to the Transaction for which this Opinion has been provided must be paid.</li>
            <li>All fees and charges due to the Firm for this Opinion must be paid to the Firm.</li>
            <li>Proof, satisfactory to the Firm, must be provided that all taxes, assessments, and charges levied against the Property, which are due and payable, have been paid.</li>
            <li>An executed and recorded release or satisfaction, discharge, subordination, and/or proof of payoff satisfactory to the Firm, must be provided for each of the encumbrances listed in <strong>Exhibit B</strong>.</li>
            <li>All documents that are required to create the Mortgage must be properly authorized, executed, delivered, and filed for record in the Public Records, with all required fees and taxes paid in full.</li>
            <li>If applicable, all documents that are required to convey the Title to the Property are properly authorized, executed, delivered, recorded, and indexed in the Public Records of <strong><?= h($fmd_data["County"])." " ?><?= h($fmd_data["State"]) ?></strong> prior to the recordation of the Mortgage.</li>
        </ol>
    </div>

    <div class="section">
        <h3>V. Limitations and Exceptions</h3>
        <p>
            This Opinion is subject to the limitations and exceptions noted below and in Exhibit B, as to which the Firm does not express an opinion and shall have no liability whatsoever (including, but not limited to, costs, attorneys’ fees, or expenses related thereto) with respect to: (a) the rights of persons in possession other than record titleholders; (b) any rights under unrecorded mechanics and materialmens liens or claims for work and materials furnished; (c) rights shown by instruments filed under the Uniform Commercial Code; (d) the location of the real estate, or of any boundary fences or easements; (e) any dominant or servient easements; (f) zoning ordinances or other unrecorded restrictions; (g) special assessments not shown by the examination; (h) mortgages, deeds of trust, and related instruments recorded with the Secretary of State of <?= h($fmd_data["State"]) ?>. (i) judgments, liens, HOA dues, pending litigation and other claims in Federal Court; (j) child support liens not recorded; (k) conveyances which are subject to the Uniform Fraudulent Transfer Act; (l) real estate taxes and assessments for the current year and subsequent years that are not yet due and payable; (m) eminent domain or rights of eminent domain, or any governmental police power; (n) encroachments and subsurface conditions not appearing in the Public Records as of the Effective Date; (o) any matter created, assumed, suffered, or agreed upon either by the Lender and/or the Borrower; (p) any errors or omissions in the Public Record; and, (q) riparian or littoral rights to any aspect of the Property.
        </p>
        <p>Additionally, unless the Firm receives a survey acceptable to the Firm, this Opinion is further subject to the effect on the Title of any matters that an accurate and complete land title survey of the Property would disclose. If the Firm does receive such an acceptable survey, it may, in its sole discretion, delete this paragraph and add any additional exceptions related to such a survey.</p>
        <p>Your attention is specifically directed to these limitations and exceptions in order that you may satisfy yourself as to such matters independently.</p>
    </div>

    <div class="section">
        <h3>VI.	ARM Loans.</h3>
        <p>If the Subject Mortgage is an adjustable-rate mortgage, then the Firm’s legal opinion notes that the law of <?= h($fmd_data["State"]) ?> provides that:</p>
        <ol class="requirements" type="I">
            <li>the Lien will not become invalid or unenforceable resulting from provisions in the Mortgage that provide for changes in the interest rate calculated pursuant to the formula provided in the Mortgage; and,</li>
            <li>the priority of the Lien for the unpaid principal balance of the loan, together with interest as changed and other sums advanced by the noteholder in accordance with the provisions of the Mortgage, will not be lost as a result of changes in the rate of interest calculated pursuant to the formula provided in the Mortgage. </li>
        </ol>
    </div>

    <div class="section">
        <h3>VII. PUD Units.</h3>
        <p>If the Subject Mortgage secures a unit in a planned unit development (“PUD”), the Firm finds that:</p>
        <ol class="requirements" type="I">
            <li>There is no present violation of any restrictive covenants that are in the PUD constituent documents and restrict the use of land or the forfeiture or reversion of title;</li>
            <li>All dues applicable to the Property are current and not delinquent; and,</li>
            <li>No recorded right of first refusal to purchase the land was exercised or could have been exercised on or before the closing date of the loan, and the Firm is unaware of the existence or exercise of any right of first refusal on or before the loan's closing date.</li>
        </ol>
    </div>
    <div class="page-break"></div>
    <div class="section">
        <h3>VIII.	General Terms.</h3>
        <ol>
            <li>The Firm has only been engaged to search the Public Records, review pertinent records, and provide a legal opinion thereto. This Opinion is not an abstract of title or other representation of the status of the title or the Property.</li>
            <li>This Opinion is rendered solely for the benefit of the Lender and its successors and/or assigns as described herein and may not be shared or distributed to anyone else without the Firm’s express written permission. The Firm has no liability or obligation involving the content of this Opinion to any person other than as expressly set forth herein.</li>
            <li>This Opinion is rendered for the benefit of the Lender in connection with the purported refinance of the Property. Subject to the provisions of this Opinion, the Firm agrees to indemnify you and your successors in interest in the Mortgage appended hereto, to the full extent of any loss attributable to a breach of the Firm’s duty to exercise reasonable care and skill in the examination of the Title and the provision of this Opinion.</li>
            <li>This Opinion includes so-called "gap coverage" for the period between the loan closing and recordation of the Mortgage, as necessary and applicable.</li>
            <li>The Firm shall not have any liability relating to the unenforceability or invalidity (in whole or in part) of the Mortgage that arises out of:
                <ol type="a">
                    <li>The inability or failure of Lender to comply with applicable doing-business laws of <?= h($fmd_data["State"]) ?></li>
                    <li>Claims of usury or any truth-in-lending law or consumer credit protection; and,</li>
                    <li>The actions or omissions of the closing agent to the Transaction (unless the Firm is such closing agent).</li>
                </ol>
            </li>
            <li>This Opinion is limited solely to what is expressly stated herein, and no legal opinion is inferred or implied beyond the contents hereof. Further, this Opinion has been prepared and issued by an attorney licensed to practice law in <?= h($fmd_data["State"]) ?> and who remains in good standing as of the Effective Date.</li>
            <li>In no event will the liability of the Firm to any person or entity arising out of or related to this Opinion exceed, in the event of a loss suffered by the Lender, the lesser of the Lender’s actual sustained loss or an amount equal to the indebtedness secured by the Mortgage.</li>
        </ol>
        <p>Should you have any questions concerning this Opinion, please do not hesitate to contact us.</p>
        <p>Very truly yours,</p>
        <div class="signature">
            <?php if($flag == 'pre'){ ?>
            <p>By:</p>
            <p><strong>National Attorney Title</strong></p>
            <p><strong>5061 N. Abbe Road, Suite 1 Sheffield Village, OH 44039</strong></p>
            <p><strong>AOL@nationalattorneytitle.com</strong></p>
            <?php } if($flag == 'final'){ //echo "<pre>";print_r($vendor_data);echo "</pre>"; ?>
            <p>By:</p>
            <p><strong><?= h($vendor_data['name']) ?></strong></p>
            <p><strong><?= h($vendor_data['address']." ".$vendor_data['city']." ".$vendor_data['state']." ".$vendor_data['zip']) ?></strong></p>
            <p><strong><?= h($vendor_data['main_contact_email']) ?></strong></p>
            <?php } ?>
        </div>
    </div>
</div>
<div class="page-break"></div>
<div class="section">
    <h2 class="title">Exhibit A - Legal Description</h2>
    <p>Legal Description: <?= h($exam["LegalDescription"]) ?></p>
    <p>More commonly known as: <?= h($fmd_data["StreetNumber"]." ".$fmd_data["StreetName"]." ".$fmd_data["City"]." ".$fmd_data["County"]." ".$fmd_data["State"]." ".$fmd_data["Zip"]) ?></p>
    <p>Parcel ID: <?= h($exam["TaxAPNAccount"]) ?></p>
    <p>The property address and tax parcel identification number listed herein are provided solely for informational purposes, without warranty as to completeness.</p>
</div>

<div class="page-break"></div>
<div class="section">
    <h2 class="title">Exhibit B - Matters of Record</h2>
    <h3>Matters Affecting Title.</h3>
    <p>The opinion expressed in this Opinion is subject to the following matters affecting title and additional exceptions, as to which the Firm expresses no opinion and shall have no liability (including any liability for any costs, attorneys’ fees, or expenses related thereto):</p>
    <p>
        <ol>
            <li>See Exhibit B-1</li>
            <li>Anything known to the Lender or owner(s)/borrower(s) that would adversely affect the priority of the Lien, including but not limited to construction initiated or conducted during the ninety (90) days prior to the Effective Date and/or any unrecorded or not shown liens on the Property.</li>
        </ol>
    </p>
</div>
<div class="section1">
    <h3>Taxes</h3>
    <p>Subject to real estate taxes, assessments, water, and sewer charges, which are delinquent or due and payable or become due and payable after the Effective Date. As of the Effective Date, as published by the municipality:</p>
    <div class="row">
        <?php if ($exam["OfficialPropertyAddress"]) { ?>
            <div class="col">Property Address: <?= h($exam["OfficialPropertyAddress"]) ?></div>
        <?php } ?>
        <?php if ($exam["TaxYear"]) { ?>
            <div class="col">Tax Year: <?= h($exam["TaxYear"]) ?></div>
        <?php } ?>

        <?php if ($exam["TaxAmount"]) { ?>
            <div class="col">Tax Amount: <?= h($exam["TaxAmount"]) ?></div>
        <?php } ?>
        <?php if ($exam["TaxType"]) { ?>
            <div class="col">Tax Type: <?= h($exam["TaxType"]) ?></div>
        <?php } ?>

        <?php if ($exam["TaxPaymentSchedule"]) { ?>
            <div class="col">Payment Schedule: <?= h($exam["TaxPaymentSchedule"]) ?></div>
        <?php } ?>
        <?php if ($exam["TaxDueDate"]) { ?>
            <div class="col">Due Date: <?= h($exam["TaxDueDate"]) ?></div>
        <?php } ?>

        <?php if ($exam["TaxDeliquentDate"]) { ?>
            <div class="col">Deliquent Date: <?= h($exam["TaxDeliquentDate"]) ?></div>
        <?php } ?>
        <?php if ($exam["TaxComments"]) { ?>
            <div class="col">Comments: <?= h($exam["TaxComments"]) ?></div>
        <?php } ?>

        <?php if ($exam["TaxLandValue"]) { ?>
            <div class="col">Land Value: <?= h($exam["TaxLandValue"]) ?></div>
        <?php } ?>
        <?php if ($exam["TaxBuildingValue"]) { ?>
            <div class="col">Building Value: <?= h($exam["TaxBuildingValue"]) ?></div>
        <?php } ?>

        <?php if ($exam["TaxAPNAccount"]) { ?>
            <div class="col">APN/Account #: <?= h($exam["TaxAPNAccount"]) ?></div>
        <?php } ?>
        <?php if ($exam["TaxAssessedYear"]) { ?>
            <div class="col">Assessed Year: <?= h($exam["TaxAssessedYear"]) ?></div>
        <?php } ?>

        <?php if ($exam["TaxTotalValue2"]) { ?>
            <div class="col">Total Value: <?= h($exam["TaxTotalValue2"]) ?></div>
        <?php } ?>
        <?php if ($exam["TaxMunicipalityCounty"]) { ?>
            <div class="col">Municipality/County: <?= h($exam["TaxMunicipalityCounty"]) ?></div>
        <?php } ?>
    </div>
</div>

<div class="footer">
    <div>Property Address: <?= h($exam["OfficialPropertyAddress"]) ?><br>File Number: <?= h($fmd_data["PartnerFileNumber"]) ?></div>
    <?php if(!empty($signature_img)) { ?>
    <div style="text-align: right;">
        <img src="<?=$signature_img;?>" alt="signature" width="140" height="40">
    </div>
    <?php } ?>
</div>
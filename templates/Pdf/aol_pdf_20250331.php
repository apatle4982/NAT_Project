<style>
    body { font-family: Arial, sans-serif; font-size: 12px; }
    .title { font-weight: bold; text-align: center; text-decoration: underline; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    td, th { border: 1px solid black; padding: 5px; }
    .bold { font-weight: bold; }
</style>
<div class="container">
    <h2 class="title">LEGAL OPINION REGARDING TITLE TO REAL PROPERTY</h2>
    <p>To Whom It May Concern:</p>
    <p>
        The following legal opinion (the <span class="bold">"Opinion"</span>) regarding the state of record
        title to certain real property has been produced and issued by <span class="bold"><?= h($exam["firm_name"]) ?></span>
        (the <span class="bold">"Firm"</span>).
        Specifically, this Opinion is issued solely with respect to the following transaction (the <span class="bold">"Transaction"</span>):
    </p>
    <table>
        <tr>
            <td class="bold">Property Address:</td>
            <td><?= h($exam["OfficialPropertyAddress"]) ?></td>
            <td class="bold">Borrower(s):</td>
            <td><?= h($fmd_data["MortgagorGrantors"]) ?><br><?= h($fmd_data["StreetNumber"]." ".$fmd_data["StreetName"]." ".$fmd_data["City"]." ".$fmd_data["County"]." ".$fmd_data["State"]." ".$fmd_data["Zip"]) ?></td>
        </tr>
        <tr>
            <td class="bold">Lender:</td>
            <td><?= h($fmd_data["MortgageeLenderCompanyName"]) ?><br><?= h($fmd_data["StreetNumber"]." ".$fmd_data["StreetName"]." ".$fmd_data["City"]." ".$fmd_data["County"]." ".$fmd_data["State"]." ".$fmd_data["Zip"]) ?></td>
            <td class="bold">Loan Number:</td>
            <td><?= h($fmd_data["LoanNumber"]) ?></td>
        </tr>
        <tr>
            <td class="bold">File Number:</td>
            <td><?= h($fmd_data["PartnerFileNumber"]) ?></td>
            <td class="bold">Loan Amount:</td>
            <td><?= h($fmd_data["LoanAmount"]) ?></td>
        </tr>
    </table>
    <p>
        The Lender has requested a letter certifying that the loan referenced above
        (the <span class="bold">"Mortgage"</span>) will hold the priority expected (the <span class="bold">"Required Priority"</span>).
        Pursuant to this request, we have examined a public records search of title certified
        to <span class="bold"><?= h($exam["lender_name"]) ?></span>, its successors and/or assigns (the <span class="bold">"Lender"</span>),
        dated <span class="bold"><?= h($exam["date"]) ?></span> (the <span class="bold">"Effective Date"</span>), regarding the real property identified
        in the Legal Description attached as Exhibit A and incorporated by reference herein (the <span class="bold">"Property"</span>).
    </p>
</div>
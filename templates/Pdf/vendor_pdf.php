<style>
h2, h3 {  text-align: center; } .container {  width: 98%;  margin: auto; } table {  width: 100%;  border-collapse: collapse; } th, td {  border: 1px solid black;  padding: 8px;  text-align: left; } .addtable th, .addtable td { border: none !important;} .red-text {  color: red; } .blue-link {  color: blue;  text-decoration: none; } .blue-link:hover {  text-decoration: underline; }
</style>
    <div class="container">
    <?php
    //echo "<pre>";print_r($fmd_data);echo "</pre>";
    ?>
        <p style="text-align: center;"><img src="<?= $this->Url->build('/img/tenxlogo-svg.jpg', ['fullBase' => true]) ?>" alt="LRS" style="height: 60px;"></p>
        <h3>Request for Title Exam<br><?= date('m/d/Y H:i:s') ?></h3>
        <p><strong>To:</strong> <?= $vendor_data['main_contact_email'] ?></p>
        <p><strong>Search Request:</strong> <?= $fva_data['search_criteria_name'] ?></p>
        <table>
            <tr>
                <td><b>FileStartDate:</b> <?= $fmd_data['FileStartDate'] ?></td>
                <td><b>NATFileNumber:</b> <?= $fmd_data['NATFileNumber'] ?></td>
            </tr>
            <tr>
                <td><b>PartnerFileNumber:</b> <?= $fmd_data['PartnerFileNumber'] ?></td>
                <td><b>APN/Parcel Number:</b> <?= $fmd_data['APNParcelNumber'] ?></td>
            </tr>
            <tr>
                <td><b>Street Number:</b> <?= $fmd_data['StreetNumber'] ?></td>
                <td><b>Street Name:</b> <?= $fmd_data['StreetName'] ?></td>
            </tr>
            <tr>
                <td><b>City:</b> <?= $fmd_data['City'] ?></td>
                <td><b>State:</b> <?= $fmd_data['State'] ?></td>
            </tr>
            <tr>
                <td><b>County:</b> <?= $fmd_data['County'] ?></td>
                <td><b>Zip:</b> <?= $fmd_data['Zip'] ?></td>
            </tr>
            <tr>
                <td><b>Grantors:</b> <?= $fmd_data['Grantors'] ?></td>
                <td><b>Grantor Marital Status:</b> <?= $fmd_data['GrantorMaritalStatus'] ?></td>
            </tr>
            <tr>
                <td><b>Grantees:</b> <?= $fmd_data['Grantees'] ?></td>
                <td><b>Grantees Marital Status:</b> <?= $fmd_data['GranteeMaritalStatus'] ?></td>
            </tr>
            <tr>
                <td colspan="2"><b>LegalDescription/ShortLegal:</b> <?= $fmd_data['LegalDescriptionShortLegal'] ?></td>
            </tr>
        </table>
        <p><br><strong>Please deliver completed Exam and Supporting Documents to:</strong></p>
        <p><a class="blue-link" href="mailto:titleexam@nationalattorneytitle.com">titleexam@nationalattorneytitle.com</a></p>
        <p><br>Thank you.</p>
        <p>National Attorney Title<br>Phone Number TBD</p>
    </div>
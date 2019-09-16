<?php
$products = [];
$productName2 = "";
$productName1 = "";
$productName1 = $sample->getProduct1->name;
if ($sample->getProduct2) {
    $productName2 = $sample->getProduct2->name;
}
$patterns = array();
$patterns[0] = '/ *\([^)]*\) */';
$replacements = array();
$replacements[0] = '';
$productName1 = preg_replace($patterns, $replacements, $productName1);
$productName2 = preg_replace($patterns, $replacements, $productName2);
array_push($products, $productName1);
if ($productName2 != "") {
    array_push($products, $productName2);
} ?>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered tbl-shopping-cart">
                <tr>
                    <th>Full Name</th>
                    <td>{{$sampleUser->first_name}} {{$sampleUser->last_name}}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{$sampleUser->email}}</td>
                </tr>
                <tr>
                    <th>Phone No</th>
                    <td>{{$sampleUser->phone_no}}</td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td>{{$sampleUser->gender == 0 ? 'Male' : 'Female'}}</td>
                </tr>
                @if($sample->company)
                    <tr>
                        <th>Company</th>
                        <td>{{$sample->company}}</td>
                    </tr>
                @endif
                <tr>
                    <th>Address</th>
                    <td>{{$sample->street}}@if($sample->street2), {{$sample->street2}}@endif,<br/>
                        {{$sample->city}}, {{isset($states[$sample->state]) ? $states[$sample->state] : $sample->state}},<br/>
                        {{$sample->postal_code}}, {{isset($countries[$sample->country]) ? $countries[$sample->country] : $sample->country}}.
                    </td>
                </tr>

                @if($sample->currently_using)
                    <tr>
                        <th>What brand are you currently using?</th>
                        <td>{{$sample->currently_using}}</td>
                    </tr>
                @endif
                <tr>
                    <th>Product{{ count($products) > 1 ? 's' : '' }}</th>
                    <td> {{implode(", ", $products)}}</td>
                </tr>
                @if($sample->weight)
                    <tr>
                        <th>Dog weight</th>
                        <td> {{$weights[$sample->weight]}}</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>

</div>
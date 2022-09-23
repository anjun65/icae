<!DOCTYPE html>
<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
		<table class='table table-bordered' style="font-size: 12px;margin-top:-10px;margin-bottom:0px">
			<tbody>
                <tr>
					<td colspan="4" style="border-right:0;"><img src="img/logo-bl.png" class="w-auto" style="height: 30px"></td>
                    <td colspan="8" style="border-left:0;" class="text-center"><b style="font-size: 18px !important;">Receipt</b></td>
				</tr>
                <tr>
					<td colspan="6" style="line-height:0;border:0;"><b>Received from</b> (Terima dari)</td>
                    <td colspan="1" style="line-height:0;border:0;">:</td>
                    <td colspan="5" style="line-height:0;border:0;"></td>
				</tr>
                <tr>
					<td colspan="6" style="min-height:10px;line-height:0;border:0;"><b>Amount</b> (Sejumlah)</td>
                    <td colspan="1" style="min-height:10px;line-height:0;border:0;">:</td>
                    <td colspan="5" style="min-height:10px;line-height:0;border:0;">Rp. {{ $nominal_transfer }}</td>
				</tr>
                <tr>
					<td colspan="6" style="min-height:10px;line-height:0;border:0;"><b>USD</b> (Terbilang)</td>
                    <td colspan="1" style="min-height:10px;line-height:0;border:0;">:</td>
                    <td colspan="5" style="min-height:10px;line-height:0;border:0;">One Million Rupiahs</td>
				</tr>
                <tr>
					<td colspan="6" style="border:0;"><b>Insettlement of</b> (Untuk Pembayaran)</td>
                    <td colspan="1" style="border:0;">:</td>
                    <td colspan="5" style="border:0;">Registration Fee For: Attendee of International Conference on Applied Engineering (ICAE 2022) For Paper Title lorem psum dolor sit amet</td>
				</tr>
                <tr>
					<td style="line-height:0;border:0;height:0px"></td>
                    <td style="line-height:0;border:0;height:0px"></td>
                    <td style="line-height:0;border:0;height:0px"></td>
                    <td style="line-height:0;border:0;height:0px"></td>
                    <td style="line-height:0;border:0;height:0px"></td>
                    <td style="line-height:0;border:0;height:0px"></td>
                    <td style="line-height:0;border:0;height:0px"></td>
                    <td style="line-height:0;border:0;height:0px"></td>
                    <td style="line-height:0;border:0;height:0px"></td>
                    <td style="line-height:0;border:0;height:0px"></td>
                    <td style="line-height:0;border:0;height:0px"></td>
                    <td style="line-height:0;border:0;height:0px"></td>
				</tr>
                <tr>
					<td colspan="6" style="line-height:0;border:0;">Batam, 10/09/2022</td>
                    <td colspan="6" style="border:0;"></td></td>
				</tr>
                <tr>
					<td colspan="6" style="line-height:0;border:0;"><b>Accepted by</b> (diterima dari):</td>
                    <td colspan="6" style="border:0;"></td></td>
				</tr>
                <tr>
					<td colspan="6" style="border:0;"><img src="img/ttd.png" class="w-auto" style="position:absolute;height: 40px;"></td>
				    <td colspan="6" style="border:0;"></td></td>
                </tr>
                <tr>
					<td colspan="6" style="border:0;">ICAE 2022 Commitee</td>
                    <td colspan="6" style="border:0;"></td></td>
				</tr>
			</tbody>
		</table>
 
</body>
</html>
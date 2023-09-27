<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <table class="table table-borderless">
        <tr>
            <td style="border-bottom: 3px black !important"><img src="img/logo-bl.png" class="w-auto" style="height: 50px"></td>
            <td style="border-bottom: 3px black !important"></td>
            <td style="border-bottom: 3px black !important" class="text-right">{{ $item->tanggal_transfer }}</td>
        </tr>

        <tr>
            <td>
                From<br/>
                <b>ICAE 2023</b><br/>
                Jl. Ahmad Yani Batam Kota<br/>
                Kota Batam, Kepulauan Riau<br/>
                Indonesia<br/>
                Phone: +62-778-469858<br/>
                Ext.1017<br/>
                Email: icae@polibatam.ac.id
            </td>
            <td>
                To<br/>
                {{ $item->user->name }}<br/>
                {{ $item->user->email }}
            </td>
            <td>
                @if($item->verification_status == 'Approved')
                    Kwitansi
                @else
                    Invoice
                @endif
                 #{{ $item->id}}<br/>
                <br/>
                <b>Register As</b>: {{ $item->user->roles }}<br/>
                <b>Register Date</b>: {{ $item->user->created_at->toDateString() }}
            </td>
        </tr>
    </table>

    <table class="table table-striped">
        <thead>
            <tr>
                <td>
                    #ID EDAS
                </td>
                <td>
                    Paper Code
                </td>
                <td>
                    Title
                </td>
            </tr>
        </thead>
        <tbody>
            @forelse ($papers as $paper)
            <tr>
                <td>
                    {{ $paper->user->edas_id }}
                </td>
                <td>
                    {{ $paper->paper_code }}
                </td>
                <td>
                    {{ $paper->paper_title }}
                </td>
            </tr>

            @empty
            <tr>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
            </tr>
            @endforelse
            
        </tbody>
    </table>
    <br/>

    <table class="table table-striped">
        <thead>
            <tr>
                <td>
                    #ID EDAS
                </td>
                <td>
                    Poster Code
                </td>
                <td>
                    Title
                </td>
            </tr>
            
        </thead>
        <tbody>
            @forelse ($posters as $poster)
            <tr>
                <td>
                    {{ $poster->user->edas_id }}
                </td>
                <td>
                    {{ $poster->paper_code }}
                </td>
                <td>
                    {{ $paper->paper_title }}
                </td>
            </tr>

            @empty
            <tr>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="table table-striped">
        <tbody>
            <tr>
                <td rowspan="2">
                    <i>This is Computer generated document.</i><br/>
                    
                </td>
                <td>
                    Subtotal: 
                    @if ($item->user->roles == 'Indonesia Reguler' || $item->user->roles == 'Indonesia Student' || $item->user->roles == 'Poster Reguler' || $item->user->roles =='Poster Student' )
                        Rp.

                    @else
                        USD
                    @endif
                    {{ $item->nominal_transfer }}
                </td>
            </tr>
            <tr>
                <td>
                    Total: 
                    @if ($item->user->roles == 'Indonesia Reguler' || $item->user->roles == 'Indonesia Student' || $item->user->roles == 'Poster Reguler' || $item->user->roles =='Poster Student' )
                        Rp.

                    @else
                        USD
                    @endif
                    {{ $item->nominal_transfer }}
                    @if($item->verification_status == 'Approved')
                        <br/>
                        <img src="img/icae-stempel.png" class="ml-1 mt-3 w-auto position-absolute" style="height: 80px">
                        <br/>
                        <img src="img/ttd-bendahara.png" class="w-auto" style="height: 80px">
                        <br/>
                        Bendahara ICAE 2023
                    @endif
                </td>
            </tr>



            
        </tbody>
    </table>
 
</body>
</html>
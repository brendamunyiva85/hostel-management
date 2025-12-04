<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Hostel Summary Report</h1>
    <table>
        <thead>
            <tr>
                <th>Hostel</th><th>Type</th><th>Total Beds</th><th>Occupied</th><th>Available</th><th>Occupancy %</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hostels as $h)
            <tr>
                <td>{{ $h->name }}</td>
                <td>{{ ucfirst($h->type) }}</td>
                <td>{{ $h->total_beds }}</td>
                <td>{{ $h->occupied_beds }}</td>
                <td>{{ $h->available_beds }}</td>
                <td>{{ $h->total_beds > 0 ? round(($h->occupied_beds / $h->total_beds) * 100, 1) : 0 }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
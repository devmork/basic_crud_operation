<?php
include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEAM: Crud Activity</title>
    <link rel="stylesheet" href="styles/index.css">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header Section -->
        <div class="bg-white rounded-lg shadow-md p-8 mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="text-4xl">📋</span>
                    Attendance Management
                </h1>
                <p class="text-gray-600 mt-2">Track and manage attendance records with Create, Read, Update, and Delete operations</p>
            </div>
            <a href="add.php" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-200 flex items-center gap-2">
                <span class="text-xl">+</span>
                Add Attendance
            </a>
        </div>

        <!-- Records Section -->
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <span>📊</span>
                    Attendance Records
                </h2>
                <span class="bg-gray-200 text-gray-700 px-4 py-2 rounded-full text-sm font-medium">
                    <?php echo mysqli_num_rows($result); ?> records
                </span>
            </div>

            <!-- Attendance Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Start Time</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">End Time</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Format date
                                $date = date('M d, Y', strtotime($row['date']));
                                
                                // Format times
                                $start_time = date('g:i A', strtotime($row['start_time']));
                                $end_time = date('g:i A', strtotime($row['end_time']));
                                
                                // Calculate duration
                                $start = new DateTime($row['start_time']);
                                $end = new DateTime($row['end_time']);
                                $interval = $start->diff($end);
                                $duration = $interval->format('%hh %im');
                                
                                echo "<tr class='hover:bg-gray-50 transition duration-150'>";
                                echo "<td class='px-6 py-4 text-sm text-gray-900'>" . $row['id'] . "</td>";
                                echo "<td class='px-6 py-4 text-sm font-medium text-gray-900'>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td class='px-6 py-4 text-sm text-gray-700'>" . $date . "</td>";
                                echo "<td class='px-6 py-4 text-sm text-gray-700'>" . $start_time . "</td>";
                                echo "<td class='px-6 py-4 text-sm text-gray-700'>" . $end_time . "</td>";
                                echo "<td class='px-6 py-4'><span class='bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full'>" . $duration . "</span></td>";
                                echo "<td class='px-6 py-4 text-sm flex gap-2'>";
                                echo "<a href='edit.php?id=" . $row['id'] . "' class='bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-1'>";
                                echo "<span>✏️</span> Edit";
                                echo "</a>";
                                echo "<a href='delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this record?\")' class='bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200 flex items-center gap-1'>";
                                echo "<span>🗑️</span> Delete";
                                echo "</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='px-6 py-12 text-center text-gray-500'>No attendance records found. Click 'Add Attendance' to create one.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
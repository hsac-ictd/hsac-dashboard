import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"

export default function PrexcTargetsTable() {
  const rowColors = [
    "bg-yellow-100 border-yellow-300 text-gray-900",
    "bg-yellow-200 border-yellow-400 text-gray-900",
    "bg-yellow-300 border-yellow-500 text-gray-900",
    "bg-yellow-400 border-yellow-600 text-gray-900",
    "bg-yellow-500 border-yellow-700 text-gray-900",
  ]

  const data = [
    { indicator: "Indicator 1", target: 100, accomplishment: 90, percent: "90%" },
    { indicator: "Indicator 2", target: 150, accomplishment: 120, percent: "80%" },
    { indicator: "Indicator 3", target: 200, accomplishment: 180, percent: "90%" },
    { indicator: "Indicator 4", target: 120, accomplishment: 100, percent: "83%" },
    { indicator: "Indicator 5", target: 180, accomplishment: 160, percent: "89%" },
  ]

  return (
    <div className="w-full opacity-90 dark:opacity-80">
      <Table
        className="
          w-full
          table-auto
          border border-gray-300 dark:border-gray-600
          rounded-lg
          text-gray-900 dark:text-gray-100
          text-sm
          bg-white/70 dark:bg-white/10 backdrop-blur-sm
        "
      >
        <TableHeader className="border-b border-gray-300 dark:border-gray-600">
          <TableRow>
            <TableHead className="px-2 py-3 border-r border-gray-300 dark:border-gray-600 text-left">
              Indicator
            </TableHead>
            <TableHead className="px-2 py-3 border-r border-gray-300 dark:border-gray-600 text-right">
              Target
            </TableHead>
            <TableHead className="px-2 py-3 border-r border-gray-300 dark:border-gray-600 text-right">
              Accomplishment
            </TableHead>
            <TableHead className="px-2 py-3 text-right">
              Percentage of Accomplishment
            </TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          {data.map(({ indicator, target, accomplishment, percent }, i) => (
            <TableRow
              key={indicator}
              className={`hover:bg-yellow-300 border-b ${rowColors[i]} `}
            >
              <TableCell className="px-2 py-3 border-r text-gray-900">
                {indicator}
              </TableCell>
              <TableCell className="px-2 py-3 border-r text-right text-gray-900">
                {target}
              </TableCell>
              <TableCell className="px-2 py-3 border-r text-right text-gray-900">
                {accomplishment}
              </TableCell>
              <TableCell className="px-2 py-3 text-right text-gray-900">{percent}</TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </div>
  )
}

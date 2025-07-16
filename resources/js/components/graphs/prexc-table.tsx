import React from "react"
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"

interface IndicatorData {
  id: number
  indicator: string
  target: number
  accomplishment: number
  percentage_of_accomplishment: number
  year: number
}

interface PrexcTargetsTableProps {
  data: IndicatorData[]
}

export default function PrexcTargetsTable({ data }: PrexcTargetsTableProps) {
  // You can keep your row colors or generate dynamically if you want to cycle
  const rowColors = [
    "bg-yellow-100 border-yellow-300 text-gray-900",
    "bg-yellow-200 border-yellow-400 text-gray-900",
    "bg-yellow-300 border-yellow-500 text-gray-900",
    "bg-yellow-400 border-yellow-600 text-gray-900",
    "bg-yellow-500 border-yellow-700 text-gray-900",
  ]

    const currentYear = new Date().getFullYear();

  if (!data.length) {
    return <div className="text-gray-700 dark:text-gray-300">No data available</div>
  }

  return (
    <div className="w-full opacity-90 dark:opacity-80 space-y-4">
      <div className="text-3xl font-bold text-white text-center flex justify-center items-center gap-3">
        Program Expenditure Classification
        <span className="text-3xl font-semibold text-white ">{currentYear}</span>
      </div>

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
          {data.map(({ id, indicator, target, accomplishment, percentage_of_accomplishment }, i) => (
            <TableRow
              key={id}
              className={`hover:bg-yellow-300 border-b ${rowColors[i % rowColors.length]}`}
            >
              <TableCell className="px-2 py-4 border-r text-gray-900">{indicator}</TableCell>
              <TableCell className="px-2 py-4 border-r text-right text-gray-900">{target}</TableCell>
              <TableCell className="px-2 py-4 border-r text-right text-gray-900">{accomplishment}</TableCell>
              <TableCell className="px-2 py-4 text-right text-gray-900">{percentage_of_accomplishment}%</TableCell>
            </TableRow>
          ))}
        </TableBody>
      </Table>
    </div>
  )
}

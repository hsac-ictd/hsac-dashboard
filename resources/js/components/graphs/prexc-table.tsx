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
  "bg-orange-100 border-orange-300 text-gray-900",
  "bg-orange-200 border-orange-400 text-gray-900",
  "bg-orange-300 border-orange-500 text-gray-900",
  "bg-orange-400 border-orange-600 text-gray-900",
  "bg-orange-500 border-orange-700 text-gray-900",
];


    const currentYear = new Date().getFullYear();

  if (!data.length) {
    return <div className="text-gray-700 dark:text-gray-300">No data available</div>
  }

  return (
   <div className="w-full space-y-4 text-white">
  <div className="text-3xl font-bold text-center flex justify-center items-center gap-3">
    Program Expenditure Classification
    <span className="text-3xl font-semibold">{currentYear}</span>
  </div>

      <Table
  className="
    w-full
    table-auto
    border border-gray-300 dark:border-gray-600
    text-gray-900 dark:text-gray-100
    text-sm
    bg-white/70 dark:bg-white/10 backdrop-blur-sm
    rounded-md
  "
>


        <TableHeader className="border-b border-gray-300 dark:border-gray-600">
      <TableRow>
        <TableHead className="px-2 py-3 border-r border-gray-300 dark:border-gray-600 text-left text-white font-bold">
          Indicator
        </TableHead>
        <TableHead className="px-2 py-3 border-r border-gray-300 dark:border-gray-600 text-right text-white font-bold">
          Target
        </TableHead>
        <TableHead className="px-2 py-3 border-r border-gray-300 dark:border-gray-600 text-right text-white font-bold">
          Accomplishment
        </TableHead>
        <TableHead className="px-2 py-3 text-right text-white font-bold">
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
                <TableCell className="px-2 py-4 border-r text-gray-900 font-bold">{indicator || "N/A"}</TableCell>

                <TableCell className="px-2 py-4 border-r text-right text-gray-900 font-bold">
                  {target && target !== 0 ? `${target}%` : "N/A"}
                </TableCell>

                <TableCell className="px-2 py-4 border-r text-right text-gray-900 font-bold">
                  {accomplishment && accomplishment !== 0 ? `${accomplishment}%` : "N/A"}
                </TableCell>

                <TableCell className="px-2 py-4 text-right text-gray-900 font-bold">
                  {percentage_of_accomplishment && percentage_of_accomplishment !== 0
                    ? `${percentage_of_accomplishment}%`
                    : "N/A"}
                </TableCell>

                </TableRow>
              ))}
            </TableBody>
      </Table>
    </div>
  )
}

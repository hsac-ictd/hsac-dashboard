import React from "react"
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table"

interface IndicatorData {
  id: number
  description: string
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
  const rowColors = [
    "bg-orange-100 border-orange-300 text-gray-900",
    "bg-orange-200 border-orange-400 text-gray-900",
    "bg-orange-300 border-orange-500 text-gray-900",
    "bg-orange-400 border-orange-600 text-gray-900",
    "bg-orange-500 border-orange-700 text-gray-900",
  ]

  const currentYear = new Date().getFullYear()

  if (!data.length) {
    return <div className="text-gray-700 dark:text-gray-300">No data available</div>
  }

  return (
    <div className="w-full space-y-4 text-white">
      <div className="text-2xl font-bold text-center flex justify-center items-center gap-2">
        Program Expenditure Classification
        <span className="text-2xl font-semibold">{currentYear}</span>
      </div>

      {/* Responsive Wrapper */}
      <div className="w-full overflow-auto rounded-md border border-white/20 backdrop-blur-sm bg-white/70 dark:bg-white/10">
        <Table className="w-full max-w-full text-xs text-gray-900 dark:text-gray-100 table-fixed">
            <TableHeader>
              <TableRow>
                <TableHead className="px-2 py-3 border-r text-left font-bold text-white w-[50%]">Indicators</TableHead>
                <TableHead className="px-2 py-3 border-r text-right font-bold text-white w-[16%] text-center">Target</TableHead>
                <TableHead className="px-2 py-3 border-r text-right font-bold text-white w-[16%] text-center">Accomplishment</TableHead>
                <TableHead className="px-2 py-3 text-right font-bold text-white w-[18%] text-center">Percentage</TableHead>
              </TableRow>
            </TableHeader>


          <TableBody>
            {data.map(({ id, description, indicator, target, accomplishment, percentage_of_accomplishment }, i) => (
              <TableRow
                key={id}
                className={`hover:bg-yellow-300 border-b ${rowColors[i % rowColors.length]}`}
              >
                <TableCell
                  className="px-2 py-3 border-r text-gray-900 text-xs font-semibold leading-snug whitespace-normal break-words"
                  style={{ maxWidth: '140px', wordWrap: 'break-word' }}
                >
                  {description || "N/A"}
                </TableCell>
                <TableCell className="px-2 py-3 border-r text-right text-gray-900 text-sm font-semibold text-center">
                  {target && target !== 0 ? `${target}%` : "N/A"}
                </TableCell>
                <TableCell className="px-2 py-3 border-r text-right text-gray-900 text-sm font-semibold text-center">
                  {accomplishment && accomplishment !== 0 ? `${accomplishment}%` : "N/A"}
                </TableCell>
                <TableCell className="px-2 py-3 text-right text-gray-900 text-sm font-semibold text-center">
                  {percentage_of_accomplishment && percentage_of_accomplishment !== 0
                    ? `${percentage_of_accomplishment}%`
                    : "N/A"}
                </TableCell>
              </TableRow>
            ))}
          </TableBody>
        </Table>
      </div>
    </div>
  )
}

import React from "react";
import { TrendingUp, TrendingDown } from "lucide-react";
import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "@/components/ui/table";

interface IndicatorData {
  id: number;
  description: string;
  indicator: string;
  target: number;
  accomplishment: number;
  percentage_of_accomplishment: number;
  year: number;
}

interface PrexcTargetsTableProps {
  data: IndicatorData[];
}

export default function PrexcTargetsTable({ data }: PrexcTargetsTableProps) {
  const rowStyle = {
    backgroundColor: "rgba(68, 111, 227, 0.24)", // darker blue with 70% opacity
  };

  const currentYear = new Date().getFullYear();

  if (!data.length) {
    return <div className="text-gray-700 dark:text-gray-300">No data available</div>;
  }

  return (
    <div className="w-full space-y-4 text-white">
      <div className="text-2xl font-bold text-center flex justify-center items-center gap-2">
        Program Expenditure Classification
        <span className="text-2xl font-semibold">{currentYear}</span>
      </div>

      {/* Responsive Wrapper */}
     <div className="w-full overflow-auto rounded-md border border-gray-700/90 backdrop-blur-sm bg-blue-950/70">

        <Table className="w-full max-w-full text-xs text-white table-fixed">
          <TableHeader>
  <TableRow>
    <TableHead className="px-2 py-3 border-r-2 border-gray-700 text-left font-bold w-[50%] text-white">
      Indicators
    </TableHead>
    <TableHead className="px-2 py-3 border-r-2 border-gray-700 text-right font-bold w-[16%] text-center text-white">
      Target
    </TableHead>
    <TableHead className="px-2 py-3 border-r-2 border-gray-700 text-right font-bold w-[16%] text-center text-white">
      Accomplishment
    </TableHead>
    <TableHead className="px-2 py-3 text-right font-bold w-[18%] text-center text-white border-gray-700 border-0 border-l-2">
      Percentage
    </TableHead>
  </TableRow>
</TableHeader>

<TableBody>
  {data.map(
    (
      {
        id,
        description,
        indicator,
        target,
        accomplishment,
        percentage_of_accomplishment,
      },
      i
    ) => (
      <TableRow key={id} className="border-b-2 border-gray-700" style={rowStyle}>
        <TableCell
          className="px-2 py-3 border-r-2 border-gray-700 text-xs font-semibold leading-snug whitespace-normal break-words text-white"
          style={{ maxWidth: "140px", wordWrap: "break-word" }}
        >
          {description || "N/A"}
        </TableCell>

        <TableCell className="px-2 py-3 border-r-2 border-gray-700 text-right text-sm font-semibold text-center text-white">
          {target && target !== 0 ? `${target}%` : "N/A"}
        </TableCell>

        <TableCell className="px-2 py-3 border-r-2 border-gray-700 text-right text-sm font-semibold text-center text-white">
          {accomplishment && accomplishment !== 0 ? `${accomplishment}%` : "N/A"}
        </TableCell>

        <TableCell
          className={`px-2 py-3 text-right text-sm font-semibold text-center ${
            percentage_of_accomplishment >= 100
              ? "text-green-400"
              : percentage_of_accomplishment < 100 && percentage_of_accomplishment !== 0
              ? "text-red-400"
              : "text-gray-400"
          } border-l-2 border-gray-700`}
        >
          {percentage_of_accomplishment && percentage_of_accomplishment !== 0 ? (
            <span className="whitespace-nowrap inline-flex items-center gap-1">
              {percentage_of_accomplishment >= 100 ? (
                <TrendingUp className="w-4 h-4 text-green-400" />
              ) : (
                <TrendingDown className="w-4 h-4 text-red-400" />
              )}
              {percentage_of_accomplishment}%
            </span>
          ) : (
            "N/A"
          )}
        </TableCell>
      </TableRow>
    )
  )}
</TableBody>

        </Table>
      </div>
    </div>
  );
}

"use client"

import { Bar, BarChart, CartesianGrid, XAxis, Tooltip, Cell, YAxis, ResponsiveContainer, LabelList } from "recharts"

import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"
import {
  ChartConfig,
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
} from "@/components/ui/chart"

interface NCasesDisposedYearlyProps {
  data: Array<{ year: string; disposed: number }>
}

// Define a light-to-dark palette (example: blue shades)
const colors = [
  "rgba(59, 130, 246, 0.4)", // light blue (Tailwind blue-400 @ 40% opacity)
  "rgba(59, 130, 246, 0.6)",
  "rgba(59, 130, 246, 0.75)",
  "rgba(59, 130, 246, 0.9)",
  "rgba(59, 130, 246, 1)", // full blue (Tailwind blue-500)
]

const chartConfig = {
  disposed: {
    label: "Cases Disposed",
    color: "var(--chart-1)",
  },
} satisfies ChartConfig

export function NCasesDisposedYearly({ data }: NCasesDisposedYearlyProps) {
  // Calculate total disposed (optional display)
  const totalDisposed = data.reduce((acc, cur) => acc + cur.disposed, 0)

  return (
<Card className="flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg">
  <CardHeader className="text-white">
    <CardTitle className="text-white">Yearly RAB Cases Disposed</CardTitle>
    <CardDescription className="text-white">By Year</CardDescription>
  </CardHeader>

      <CardContent className="h-[183px] p-0 overflow-visible">
        {/* Optionally show total disposed here if you want */}
        {/* <div className="mb-2 font-semibold text-sm">Total Disposed: {totalDisposed}</div> */}

        <ChartContainer config={chartConfig}>
          <div className="h-full w-full">
            <ResponsiveContainer width="100%" height="100%">
              <BarChart
                data={data}
                margin={{ top: 20, right: 5, bottom: 55, left: 5 }} // increased top margin for label space
                barCategoryGap={10}
              >
                <CartesianGrid vertical={false} />
                <XAxis dataKey="year" tickLine={false} tickMargin={8} axisLine={true} />
                <YAxis type="number" domain={[0, 'dataMax']} hide />
                <ChartTooltip cursor={false} content={<ChartTooltipContent hideLabel />} />
                <Bar dataKey="disposed" radius={[4, 4, 0, 0]}>
                  {data.map((entry, index) => (
                    <Cell key={`cell-${index}`} fill={colors[index % colors.length]} />
                  ))}
                  {/* Add LabelList to show the numbers on top */}
                  <LabelList dataKey="disposed" position="top" style={{ fill: '#fafafaff', fontWeight: 'bold' }} />
                </Bar>
              </BarChart>
            </ResponsiveContainer>
          </div>
        </ChartContainer>
      </CardContent>
    </Card>
  )
}
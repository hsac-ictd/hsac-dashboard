"use client"

import { Bar, BarChart, CartesianGrid, XAxis, LabelList } from "recharts"

import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
  CardDescription,
} from "@/components/ui/card"
import {
  ChartConfig,
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
} from "@/components/ui/chart"

const data = [
  { name: "REM", newCasesFiled: 12, disposed: 7 },
  { name: "HOA", newCasesFiled: 8, disposed: 9 },
]

const orange = "#fe9a00"
const yellow = "#ffd230"

const chartConfig = {
  newCasesFiled: {
    label: "New Cases Filed",
    color: orange,
  },
  disposed: {
    label: "Disposed",
    color: yellow,
  },
} satisfies ChartConfig

export function RabCaseTypeChart() {
  const totalNewCasesFiled = data.reduce((acc, cur) => acc + cur.newCasesFiled, 0)
  const totalDisposed = data.reduce((acc, cur) => acc + cur.disposed, 0)

  return (
        <Card className="flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg h-80">
          
      <CardHeader>
        <CardTitle>RAB CASE TYPE</CardTitle>
        <CardDescription>Recent case filing and disposition data</CardDescription>
      </CardHeader>
      <CardContent>
        {/* Totals above chart */}
        <div className="mb-4 flex gap-6 text-sm font-semibold">
          <div style={{ color: orange }}>Total New Cases Filed: {totalNewCasesFiled}</div>
          <div style={{ color: yellow }}>Total Disposed: {totalDisposed}</div>
        </div>

        <ChartContainer config={chartConfig}>
          <BarChart
            data={data}
            margin={{ top: 20, right: 20, left: 20, bottom: 40 }}
          >
            <CartesianGrid vertical={false} />
            <XAxis
              dataKey="name"
              tickLine={false}
              tickMargin={10}
              axisLine={false}
            />
            <ChartTooltip
              cursor={false}
              content={<ChartTooltipContent indicator="dashed" />}
            />
            <Bar dataKey="newCasesFiled" fill={orange} radius={4}>
              <LabelList
                dataKey="newCasesFiled"
                position="bottom"
                offset={10}
                style={{ fill: orange, fontWeight: 600, fontSize: 12 }}
              />
            </Bar>
            <Bar dataKey="disposed" fill={yellow} radius={4}>
              <LabelList
                dataKey="disposed"
                position="bottom"
                offset={10}
                style={{ fill: yellow, fontWeight: 600, fontSize: 12 }}
              />
            </Bar>
          </BarChart>
        </ChartContainer>
      </CardContent>
    </Card>
  )
}

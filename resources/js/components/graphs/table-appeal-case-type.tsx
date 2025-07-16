"use client"

import { Bar, BarChart, CartesianGrid, XAxis, LabelList, ResponsiveContainer } from "recharts"

import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/components/ui/card"
import {
  ChartConfig,
  ChartContainer,
  ChartTooltip,
  ChartTooltipContent,
} from "@/components/ui/chart"

const green = "rgba(0, 153, 51, 0.9)";
const gold = "rgba(100, 149, 237, 0.9)";

const chartConfig = {
  newCasesFiled: {
    label: "Cases Filed",
    color: green,
  },
  disposed: {
    label: "Disposed",
    color: gold,
  },
} satisfies ChartConfig

interface AppealCaseTypeChartProps {
  data: Array<{
    name: string
    newCasesFiled: number
    disposed: number
  }>
}

export function AppealCaseTypeChart({ data }: AppealCaseTypeChartProps) {
  const totalNewCases = data.reduce((acc, cur) => acc + cur.newCasesFiled, 0)
  const totalDisposed = data.reduce((acc, cur) => acc + cur.disposed, 0)
  const currentYear = new Date().getFullYear()

  return (
    <Card className="flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg h-80 sm:h-[450px] md:h-[500px] lg:h-80">
      <CardHeader>
        <CardTitle className="text-base md:text-xl lg:text-2xl">APPEAL CASE TYPE</CardTitle>
        <CardDescription className="text-xs md:text-sm">{currentYear} - Present</CardDescription>
      </CardHeader>

      <CardContent className="flex-1 w-full">
        <div className="mb-4 flex flex-col sm:flex-row gap-4 sm:gap-6 text-xs sm:text-sm font-semibold">
          <div className="flex items-center gap-2 text-white">
            <div className="w-4 h-4 rounded-sm" style={{ backgroundColor: green }} />
            Total Cases Filed: {totalNewCases}
          </div>
          <div className="flex items-center gap-2 text-white">
            <div className="w-4 h-4 rounded-sm" style={{ backgroundColor: gold }} />
            Total Disposed: {totalDisposed}
          </div>
        </div>

        <ChartContainer config={chartConfig}>
          <div className="w-full h-full min-h-[200px]">
            <ResponsiveContainer width="100%" height="100%">
              <BarChart
                data={data}
                margin={{ top: 20, right: 20, left: 20, bottom: 50 }}
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
                <Bar dataKey="newCasesFiled" fill={green} radius={4}>
                  <LabelList
                    dataKey="newCasesFiled"
                    position="insideTop"
                    style={{ fill: "#fff", fontWeight: 600, fontSize: 12 }}
                  />
                </Bar>
                <Bar dataKey="disposed" fill={gold} radius={4}>
                  <LabelList
                    dataKey="disposed"
                    position="insideTop"
                    style={{ fill: "#fff", fontWeight: 600, fontSize: 12 }}
                  />
                </Bar>

              </BarChart>
            </ResponsiveContainer>
          </div>
        </ChartContainer>
      </CardContent>
    </Card>
  )
}

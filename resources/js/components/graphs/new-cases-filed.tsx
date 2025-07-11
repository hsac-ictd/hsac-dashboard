"use client"

import {
  Bar,
  BarChart,
  CartesianGrid,
  Cell,
  LabelList,
  XAxis,
  YAxis,
  ResponsiveContainer,
} from "recharts"

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

const chartData = [
  { region: "NCR", value: 120 },
  { region: "CAR", value: 80 },
  { region: "RAB I", value: 75 },
  { region: "RAB II", value: 90 },
  { region: "RAB III", value: 110 },
  { region: "RAB IVA", value: 150 },
  { region: "RAB IVB", value: 60 },
  { region: "RAB V", value: 70 },
  { region: "RAB VI", value: 95 },
  { region: "RAB VII", value: 100 },
  { region: "RAB VIII", value: 65 },
  { region: "RAB IX", value: 55 },
  { region: "RAB X", value: 50 },
  { region: "RAB XI", value: 45 },
  { region: "RAB XII", value: 40 },
  { region: "RAB XIII", value: 35 },
]

const chartConfig = {
  value: {
    label: "Count",
    color: "var(--chart-1)",
  },
  label: {
    color: "var(--background)",
  },
} satisfies ChartConfig

export function ChartBarHorizontal() {
  return (
    <Card className="flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg">
      <CardHeader>
        <CardTitle>Regional Distribution</CardTitle>
        <CardDescription>January - June 2024</CardDescription>
      </CardHeader>
      <CardContent>
        <ChartContainer config={chartConfig}>
          <ResponsiveContainer width="100%" height={500}>
            <BarChart
              data={chartData}
              layout="vertical"
              margin={{ right: 16 }}
              barCategoryGap="100%"
            >
              {/* Gradient Definition */}
              <defs>
                <linearGradient id="regionGradient" x1="0" y1="0" x2="1" y2="0">
                  <stop offset="0%" stopColor="#25ee9d" />
                  <stop offset="50%" stopColor="#1cd7b5" />
                  <stop offset="100%" stopColor="#07b0e8" />
                </linearGradient>
              </defs>

              <CartesianGrid horizontal={false} />
              <YAxis
                dataKey="region"
                type="category"
                tickLine={false}
                tickMargin={10}
                axisLine={false}
                hide
              />
              <XAxis dataKey="value" type="number" hide />
              <ChartTooltip
                cursor={false}
                content={<ChartTooltipContent indicator="line" />}
              />
              <Bar
                dataKey="value"
                radius={2}
                barSize={40}
                stroke="#2caa8f"
                strokeWidth={1.5}
              >
                {chartData.map((_, index) => (
                  <Cell key={`cell-${index}`} fill="url(#regionGradient)" />
                ))}
                <LabelList
                  dataKey="region"
                  position="insideLeft"
                  offset={8}
                  fill="white" // white text
                  fontSize={12}
                />
                <LabelList
                  dataKey="value"
                  position="right"
                  offset={8}
                  fill="white" // white text
                  fontSize={12}
                />
              </Bar>
            </BarChart>
          </ResponsiveContainer>
        </ChartContainer>
      </CardContent>
    </Card>
  )
}

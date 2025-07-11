"use client"

import { TrendingUp } from "lucide-react"
import { Bar, BarChart, CartesianGrid, XAxis, Tooltip, Cell } from "recharts"

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

export const description = "A yearly bar chart with gradient colors"

const chartData = [
  { year: "2020", desktop: 1200 },
  { year: "2021", desktop: 1450 },
  { year: "2022", desktop: 1320 },
  { year: "2023", desktop: 1580 },
  { year: "2024", desktop: 1700 },
]

// Define a light-to-dark palette (example: blue shades)
const colors = [
  "rgba(59, 130, 246, 0.4)", // light blue (Tailwind blue-400 @ 40% opacity)
  "rgba(59, 130, 246, 0.6)",
  "rgba(59, 130, 246, 0.75)",
  "rgba(59, 130, 246, 0.9)",
  "rgba(59, 130, 246, 1)", // full blue (Tailwind blue-500)
]

const chartConfig = {
  desktop: {
    label: "Desktop",
    color: "var(--chart-1)",
  },
} satisfies ChartConfig

export function NCasesDisposedYearly() {
  return (
        <Card className="flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg">

      <CardHeader>
        <CardTitle>Yearly Cases Disposed</CardTitle>
        <CardDescription>2020 - 2024</CardDescription>
      </CardHeader>
      <CardContent>
        <ChartContainer config={chartConfig}>
          <BarChart accessibilityLayer data={chartData}>
            <CartesianGrid vertical={false} />
            <XAxis
              dataKey="year"
              tickLine={false}
              tickMargin={10}
              axisLine={false}
            />
            <ChartTooltip
              cursor={false}
              content={<ChartTooltipContent hideLabel />}
            />
            <Bar dataKey="desktop" radius={8}>
              {chartData.map((entry, index) => (
                <Cell key={`cell-${index}`} fill={colors[index % colors.length]} />
              ))}
            </Bar>
          </BarChart>
        </ChartContainer>
      </CardContent>
      
    </Card>
  )
}

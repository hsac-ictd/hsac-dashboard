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

const orange = "rgba(44,154,147,0.9)";
const yellow = "#eecb4cff";

const chartConfig = {
  newCasesFiled: {
    label: "Cases Filed",
    color: orange,
  },
  disposed: {
    label: "Disposed",
    color: yellow,
  },
} satisfies ChartConfig;

interface RabCaseTypeChartProps {
  data: Array<{
    name: string;
    newCasesFiled: number;
    disposed: number;
  }>
}

export function RabCaseTypeChart({ data }: RabCaseTypeChartProps) {
  const totalNewCasesFiled = data.reduce((acc, cur) => acc + cur.newCasesFiled, 0);
  const totalDisposed = data.reduce((acc, cur) => acc + cur.disposed, 0);
  const currentYear = new Date().getFullYear();

  return (
    <Card className="flex flex-col bg-white/60 dark:bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg h-72 sm:h-[350px] md:h-[400px] lg:h-72">
      <CardHeader>
        <CardTitle className="text-base md:text-xl lg:text-2xl">RAB CASE TYPE</CardTitle>
        <CardDescription className="text-xs md:text-sm">{currentYear} - Present</CardDescription>
      </CardHeader>

      <CardContent className="flex-1 w-full">
        <div className="mb-4 flex flex-col sm:flex-row gap-4 sm:gap-6 text-xs sm:text-sm font-semibold">
          <div className="flex items-center gap-2 text-white">
            <div className="w-4 h-4 rounded-sm" style={{ backgroundColor: orange }} />
            Total Cases Filed: {totalNewCasesFiled}
          </div>
          <div className="flex items-center gap-2 text-white">
            <div className="w-4 h-4 rounded-sm" style={{ backgroundColor: yellow }} />
            Total Disposed: {totalDisposed}
          </div>
        </div>

        <ChartContainer config={chartConfig}>
          <div className="w-full h-full min-h-[150px]">
            <ResponsiveContainer width="100%" height="100%">
              <BarChart
                data={data}
                margin={{ top: 20, right: 20, left: 20, bottom: 80 }}
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
                    position="insideTop"
                    style={{ fill: "#fff", fontWeight: 600, fontSize: 12 }}
                  />
                </Bar>
                <Bar dataKey="disposed" fill={yellow} radius={4}>
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
  );
}
